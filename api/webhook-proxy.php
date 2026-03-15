<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw ?? '', true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON payload']);
    exit;
}

$type = $data['type'] ?? '';
$payload = $data['payload'] ?? null;

if (!is_array($payload) || empty($type)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing type or payload']);
    exit;
}

// Configure tes webhooks ici (ou via variables d'environnement serveur).
// Exemple OVH: définir DISCORD_WEBHOOK_RECRUITMENT et DISCORD_WEBHOOK_PARTNER.
$webhooks = [
    // Priorite aux variables d'environnement serveur
    'recruitment' => getenv('DISCORD_WEBHOOK_RECRUITMENT') ?: 'https://discord.com/api/webhooks/1482542896367276114/AkO1jMd3YaDsHz9RcABe4uOof8kzf5MxncrI3TN-MSuOFOHUSuTHascJMkRjaYl4rnAo',
    'partner' => getenv('DISCORD_WEBHOOK_PARTNER') ?: 'https://discord.com/api/webhooks/1482543060062568529/JhHakJOjYjB7EhEz18ZMuBv7IEt6FnJjdo7WctBrMhTTR7igpTQd-hsaplRpI3WxMWCJ',
];

$webhookUrl = $webhooks[$type] ?? '';
if (!$webhookUrl) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => "Webhook non configure pour le type: {$type}"
    ]);
    exit;
}

$ch = curl_init($webhookUrl);
$curlOptions = [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
];

// En local (WAMP), certains environnements n'ont pas de store CA valide.
// On assouplit uniquement en local pour eviter l'erreur SSL certificate problem.
$host = strtolower((string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? ''));
$isLocal = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

if ($isLocal) {
    $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
    $curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
}

curl_setopt_array($ch, $curlOptions);

$responseBody = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    http_response_code(502);
    echo json_encode(['success' => false, 'error' => 'cURL error: ' . $curlError]);
    exit;
}

// Discord répond souvent 204 No Content sur succès.
if ($httpCode < 200 || $httpCode >= 300) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'error' => 'Discord webhook error',
        'discord_status' => $httpCode,
        'discord_response' => $responseBody
    ]);
    exit;
}

echo json_encode(['success' => true]);
?>