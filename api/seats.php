<?php
/**
 * api/seats.php
 *
 * Proxy simple de solo lectura hacia el servicio de "asientos" (seats) que corre en
 * el host Windows del Demo Center. Ese servicio lleva el inventario de maquinas/RDP
 * disponibles y ocupadas; este endpoint solo reenvia esa respuesta JSON tal cual al
 * frontend (demos.php) para que pueda mostrar disponibilidad en tiempo real.
 * No recibe parametros de entrada: siempre hace GET al servicio interno.
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store'); // Evita que el navegador cachee disponibilidad desactualizada.

// Contexto HTTP para la llamada interna: timeout corto (2.5s) para no colgar la
// pagina si el host Windows no responde, e ignore_errors para poder leer el cuerpo
// aunque el servicio devuelva un codigo de error HTTP.
$ctx = stream_context_create([
    'http' => [
        'timeout' => 2.5,
        'ignore_errors' => true,
        'header' => "Accept: application/json\r\n",
    ],
]);

// IP/puerto del servicio de asientos en la red interna del Demo Center (host Windows).
$raw = @file_get_contents('http://10.1.10.203:18080/seats', false, $ctx);

// Si el host Windows no responde (apagado, red caida, timeout), devolvemos una
// respuesta JSON "vacia pero valida" con codigo 502 en vez de romper el frontend.
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
// Reenvio directo del JSON tal cual lo entrego el servicio interno.
echo $raw;
