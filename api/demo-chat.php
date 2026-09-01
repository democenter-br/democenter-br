<?php
/**
 * api/demo-chat.php
 *
 * Proxy hacia el chatbot "Borderbot" (Python + AWS Bedrock) usado en el Demo Center.
 * Aplica un limite de cuota diario (por usuario y global) antes de invocar el script
 * Python (/usr/local/lib/demo-chat/ask.py) que realmente habla con Bedrock.
 *
 * Correcciones aplicadas (2026-08-31), sin tocar credenciales/rutas operativas:
 *  1) Ya no se devuelve al cliente el stderr del proceso Python -- se registra en el
 *     log de errores de PHP (ver logBorderbotError()) para no filtrar trazas internas
 *     (rutas, modulos, posible region/cuenta de AWS) a quien visite el sitio.
 *  2) El conteo de cuota (por usuario y global) ahora usa flock() para incrementar de
 *     forma atomica (ver incrementQuotaCounter()). Antes, un simple
 *     file_get_contents()+file_put_contents() sin lock permitia que, bajo trafico
 *     simultaneo, el limite real se sobrepasara ligeramente (condicion de carrera).
 */

// TEAM-HIDE:CHATBOT — Borderbot/Bedrock deshabilitado intencionalmente en la variante
// team/partner (el widget de chat ya viene oculto en el HTML de cada pagina, ver los
// bloques "TEAM-HIDE:CHATBOT" en <head>/<body>; este switch es la defensa del lado del
// servidor para que el endpoint tampoco responda si alguien lo llama directamente).
// No borrar este archivo ni el resto del codigo de abajo: si el negocio decide volver
// a habilitar el chatbot para partners, basta con quitar estas dos lineas.
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
    echo json_encode(['error' => 'JSON invalido']);
    exit;
}

$q = trim((string) ($req['q'] ?? ''));
if ($q === '' || strlen($q) > 800) {
    http_response_code(400);
    echo json_encode(['error' => 'Pregunta vacia o demasiado larga']);
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
    echo json_encode(['error' => 'No se pudo crear cuota']);
    exit;
}

$userFile = $quotaDir . '/' . $uid;
$totalFile = $quotaDir . '/_total';

/**
 * Lee el valor entero actual de un archivo contador de cuota.
 * Usa flock(LOCK_SH) para no leer un archivo a medio escribir bajo concurrencia.
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
 * Incrementa atomicamente en 1 un archivo contador de cuota usando flock(LOCK_EX),
 * para que peticiones concurrentes no se pisen entre si. Devuelve el nuevo valor.
 */
function incrementQuotaCounter(string $file): int
{
    $fh = fopen($file, 'c+');
    if (!$fh) {
        // Si no se puede abrir/crear el archivo de cuota, fallamos "seguro":
        // devolvemos un numero alto para no permitir mas peticiones sin control.
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
 * Registra un error interno de Borderbot en el log de errores de PHP en vez de
 * devolverlo al cliente (antes se mandaban hasta 300 caracteres del stderr de
 * Python tal cual en la respuesta JSON).
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
    echo json_encode(['error' => 'Ya usaste las 3 interacciones de Borderbot por hoy. Vuelve manana.']);
    exit;
}
if ($totalN >= $globalMax) {
    http_response_code(429);
    echo json_encode(['error' => 'Borderbot llego al tope diario del Demo Center. Intenta manana.']);
    exit;
}

// Ruta del script Python que realmente habla con Bedrock -- operativa, no se modifica.
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
    echo json_encode(['error' => 'No se pudo iniciar Borderbot']);
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
    // Antes: se devolvia substr($err, 0, 300) al cliente (fuga de info interna).
    // Ahora: se loguea server-side y al cliente solo se le da un mensaje generico.
    logBorderbotError($err);
    http_response_code(500);
    echo json_encode(['error' => 'Sin respuesta de Bedrock']);
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
