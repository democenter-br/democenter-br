<?php
/**
 * api/seats.php
 *
 * Proxy simples somente leitura para o serviço de "assentos" (seats) que roda no
 * host Windows do Demo Center. Esse serviço mantém o inventário de máquinas/RDP
 * disponíveis e ocupadas; este endpoint apenas repassa essa resposta JSON como está
 * para o frontend (demos.php), para que ele possa exibir a disponibilidade em tempo real.
 * Não recebe parâmetros de entrada: sempre faz GET no serviço interno.
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store'); // Evita que o navegador faça cache de disponibilidade desatualizada.

// Contexto HTTP para a chamada interna: timeout curto (2.5s) para não travar a
// página se o host Windows não responder, e ignore_errors para poder ler o corpo
// mesmo que o serviço devolva um código de erro HTTP.
$ctx = stream_context_create([
    'http' => [
        'timeout' => 2.5,
        'ignore_errors' => true,
        'header' => "Accept: application/json\r\n",
    ],
]);

// IP/porta do serviço de assentos na rede interna do Demo Center (host Windows).
$raw = @file_get_contents('http://10.1.10.203:18080/seats', false, $ctx);

// Se o host Windows não responder (desligado, rede fora do ar, timeout), devolvemos uma
// resposta JSON "vazia, mas válida" com código 502 em vez de quebrar o frontend.
if ($raw === false || $raw === '') {
    http_response_code(502);
    echo json_encode([
        'ok' => false,
        'error' => 'windows_unreachable',
        'seats' => [],
        'free' => [],
        'busy' => [],
        'next' => null,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
// Repasse direto do JSON exatamente como entregue pelo serviço interno.
echo $raw;
