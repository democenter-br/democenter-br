<?php
/**
 * api/demo-chat.php
 *
 * Proxy para o chatbot "Borderbot" (Python + AWS Bedrock) usado no Demo Center.
 * Aplica um limite de cota diária (por usuário e global) antes de invocar o script
 * Python (/usr/local/lib/demo-chat/ask.py) que de fato conversa com o Bedrock.
 *
 * Correções aplicadas (2026-08-31), sem alterar credenciais/caminhos operacionais:
 *  1) O stderr do processo Python não é mais devolvido ao cliente -- ele é registrado no
 *     log de erros do PHP (ver logBorderbotError()) para não vazar rastros internos
 *     (caminhos, módulos, possível região/conta da AWS) a quem visitar o site.
 *  2) A contagem de cota (por usuário e global) agora usa flock() para incrementar de
 *     forma atômica (ver incrementQuotaCounter()). Antes, um simples
 *     file_get_contents()+file_put_contents() sem lock permitia que, sob tráfego
 *     simultâneo, o limite real fosse ligeiramente ultrapassado (condição de corrida).
 */

// TEAM-HIDE:CHATBOT — Borderbot/Bedrock desabilitado intencionalmente na variante
// team/partner (o widget de chat já vem oculto no HTML de cada página, veja os
// blocos "TEAM-HIDE:CHATBOT" em <head>/<body>; este switch é a defesa do lado do
// servidor para que o endpoint também não responda se alguém o chamar diretamente).
// Não apague este arquivo nem o restante do código abaixo: se o negócio decidir voltar
// a habilitar o chatbot para parceiros, basta remover estas duas linhas.
http_response_code(404);
exit;

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST only']);
    exit;
}

$raw = file_get_contents('php://input');
$req = json_decode($raw, true);
if (!is_array($req)) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

$q = trim((string) ($req['q'] ?? ''));
if ($q === '' || strlen($q) > 800) {
    http_response_code(400);
    echo json_encode(['error' => 'Pergunta vazia ou longa demais']);
    exit;
}

$uid = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) ($req['uid'] ?? ''));
if ($uid === '' || strlen($uid) > 64) {
    $uid = 'ip-' . preg_replace('/[^0-9a-fA-F:.]/', '_', $_SERVER['REMOTE_ADDR'] ?? '0');
}

$perUser = 3;
$globalMax = 80;
$day = gmdate('Y-m-d');
$quotaDir = '/var/lib/demo-chat/quota/' . $day;
if (!is_dir($quotaDir) && !@mkdir($quotaDir, 0770, true)) {
    http_response_code(500);
    echo json_encode(['error' => 'Não foi possível criar a cota']);
    exit;
}

$userFile = $quotaDir . '/' . $uid;
$totalFile = $quotaDir . '/_total';

/**
 * Lê o valor inteiro atual de um arquivo contador de cota.
 * Usa flock(LOCK_SH) para não ler um arquivo escrito pela metade sob concorrência.
 */
function readQuotaCounter(string $file): int
{
    if (!is_file($file)) {
        return 0;
    }
    $fh = @fopen($file, 'r');
    if (!$fh) {
        return 0;
    }
    $value = 0;
    if (flock($fh, LOCK_SH)) {
        $value = (int) stream_get_contents($fh);
        flock($fh, LOCK_UN);
    }
    fclose($fh);
    return $value;
}

/**
 * Incrementa atomicamente em 1 um arquivo contador de cota usando flock(LOCK_EX),
 * para que requisições concorrentes não se sobreponham. Devolve o novo valor.
 */
function incrementQuotaCounter(string $file): int
{
    $fh = fopen($file, 'c+');
    if (!$fh) {
        // Se não for possível abrir/criar o arquivo de cota, falhamos de forma "segura":
        // devolvemos um número alto para não permitir mais requisições sem controle.
        return PHP_INT_MAX;
    }
    flock($fh, LOCK_EX);
    $current = (int) stream_get_contents($fh);
    $next = $current + 1;
    rewind($fh);
    ftruncate($fh, 0);
    fwrite($fh, (string) $next);
    fflush($fh);
    flock($fh, LOCK_UN);
    fclose($fh);
    return $next;
}

/**
 * Registra um erro interno do Borderbot no log de erros do PHP em vez de
 * devolvê-lo ao cliente (antes eram enviados até 300 caracteres do stderr do
 * Python como estavam na resposta JSON).
 */
function logBorderbotError(string $err): void
{
    if ($err !== '') {
        error_log('[demo-chat] Borderbot stderr: ' . substr($err, 0, 2000));
    }
}

$userN = readQuotaCounter($userFile);
$totalN = readQuotaCounter($totalFile);

if ($userN >= $perUser) {
    http_response_code(429);
    echo json_encode(['error' => 'Você já usou as 3 interações do Borderbot por hoje. Volte amanhã.']);
    exit;
}
if ($totalN >= $globalMax) {
    http_response_code(429);
    echo json_encode(['error' => 'O Borderbot atingiu o limite diário do Demo Center. Tente novamente amanhã.']);
    exit;
}

// Caminho do script Python que de fato conversa com o Bedrock -- operacional, não deve ser modificado.
$ask = '/usr/local/lib/demo-chat/ask.py';
$proc = proc_open(
    ['python3', $ask],
    [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ],
    $pipes,
    null,
    null
);
if (!is_resource($proc)) {
    http_response_code(500);
    echo json_encode(['error' => 'Não foi possível iniciar o Borderbot']);
    exit;
}
fwrite($pipes[0], $raw);
fclose($pipes[0]);
$out = stream_get_contents($pipes[1]);
$err = stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($proc);
if (!$out) {
    // Antes: era devolvido substr($err, 0, 300) ao cliente (vazamento de info interna).
    // Agora: é registrado no servidor e ao cliente só se dá uma mensagem genérica.
    logBorderbotError($err);
    http_response_code(500);
    echo json_encode(['error' => 'Sem resposta do Bedrock']);
    exit;
}
$decoded = json_decode($out, true);
if (is_array($decoded) && !empty($decoded['a'])) {
    $newUserN = incrementQuotaCounter($userFile);
    incrementQuotaCounter($totalFile);
    $decoded['left'] = max(0, $perUser - $newUserN);
    echo json_encode($decoded, JSON_UNESCAPED_UNICODE);
    exit;
}
echo $out;
