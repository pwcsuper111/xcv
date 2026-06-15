<?php
declare(strict_types=1);

error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/config.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$action = isset($_GET['action']) ? (string) $_GET['action'] : '';

function createToken(string $category, array $indices): string
{
    sort($indices);
    $expires = time() + 120;
    $payload = $category . '|' . implode(',', $indices) . '|' . $expires;
    $sig     = hash_hmac('sha256', $payload, HMAC_SECRET);
    return base64_encode($payload . '|' . $sig);
}

function verifyToken(string $token): ?array
{
    $decoded = base64_decode($token, true);
    if ($decoded === false) {
        return null;
    }

    $parts = explode('|', $decoded);
    if (count($parts) !== 4) {
        return null;
    }

    [$category, $indexCsv, $expires, $sig] = $parts;
    $payload  = $category . '|' . $indexCsv . '|' . $expires;
    $expected = hash_hmac('sha256', $payload, HMAC_SECRET);

    if (!hash_equals($expected, $sig)) {
        return null;
    }

    if (time() > (int) $expires) {
        return null;
    }

    if (time() < (int) $expires - 119) {
        return null;
    }

    $indices = array_map('intval', explode(',', $indexCsv));

    return [
        'category' => $category,
        'indices'  => $indices,
    ];
}

function buildChallenge(): array
{
    $pool        = array_keys(TILE_SOURCES);
    $target      = $pool[array_rand($pool)];
    $distractors = array_values(array_diff($pool, [$target]));

    $tiles   = array_fill(0, 3, $target);
    $correct = [];

    while (count($tiles) < 9) {
        $tiles[] = $distractors[array_rand($distractors)];
    }

    shuffle($tiles);

    foreach ($tiles as $index => $type) {
        if ($type === $target) {
            $correct[] = $index;
        }
    }

    sort($correct);

    return [
        'category' => $target,
        'label'    => TILE_LABELS[$target] ?? $target,
        'tiles'    => $tiles,
        'correct'  => $correct,
    ];
}

if ($action === 'challenge') {
    header('Content-Type: application/json');

    $challenge = buildChallenge();
    $token     = createToken($challenge['category'], $challenge['correct']);

    $tilesOut = [];
    foreach ($challenge['tiles'] as $index => $type) {
        $tilesOut[] = [
            'id'   => $index,
            'type' => $type,
        ];
    }

    echo json_encode([
        'token'    => $token,
        'label'    => $challenge['label'],
        'category' => $challenge['category'],
        'tiles'    => $tilesOut,
    ]);
    exit;
}

if ($action === 'verify') {
    header('Content-Type: application/json');

    $input = file_get_contents('php://input');
    $data  = json_decode($input, true);

    $selected  = isset($data['selected']) && is_array($data['selected']) ? $data['selected'] : [];
    $userToken = isset($data['token']) ? (string) $data['token'] : '';

    $selected = array_values(array_unique(array_map('intval', $selected)));
    sort($selected);

    $stored = verifyToken($userToken);

    if ($stored === null) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Try again.']);
        exit;
    }

    if ($selected === $stored['indices']) {
        echo json_encode(['status' => 'success', 'redirect' => REDIRECT_URL]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Incorrect selection. Try again.']);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);
