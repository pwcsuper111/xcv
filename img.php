<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

$key = isset($_GET['k']) ? (string) $_GET['k'] : '';

$assets = [
    'logo' => ['url' => LOGO_URL, 'type' => 'image/svg+xml'],
    'icon' => ['url' => FAVICON_URL, 'type' => 'image/svg+xml'],
];

foreach (TILE_SOURCES as $tileKey => $tileUrl) {
    $assets[$tileKey] = ['url' => $tileUrl, 'type' => 'image/svg+xml'];
}

if (!isset($assets[$key])) {
    http_response_code(404);
    exit;
}

$url  = $assets[$key]['url'];
$type = $assets[$key]['type'];
$data = false;

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_USERAGENT      => 'Mozilla/5.0',
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    $data = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200 || $data === false) {
        $data = false;
    }
}

if ($data === false && function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_USERAGENT      => 'Mozilla/5.0',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
    ]);
    $data = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200 || $data === false) {
        $data = false;
    }
}

if ($data === false) {
    $ctx  = stream_context_create(['http' => ['timeout' => 10, 'header' => "User-Agent: Mozilla/5.0\r\n"]]);
    $data = @file_get_contents($url, false, $ctx);
}

if ($data === false) {
    http_response_code(502);
    exit;
}

header('Content-Type: ' . $type);
header('Cache-Control: public, max-age=86400');
echo $data;
