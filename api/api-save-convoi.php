<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer la requête preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config.php';

// Initialiser la base de données si nécessaire
initDatabase();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Validation des champs requis
$required = ['id', 'pseudo', 'discord', 'date', 'heure', 'parcours', 'description'];
foreach ($required as $field) {
    if (!isset($input[$field]) || empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Champ manquant: $field"]);
        exit;
    }
}

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO convois (id, pseudo, discord, tmp_link, truckbook_link, trucky_link, date, heure, parcours, description, rules, serveur, marchandise, date_creation)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE
            pseudo = VALUES(pseudo),
            discord = VALUES(discord),
            tmp_link = VALUES(tmp_link),
            truckbook_link = VALUES(truckbook_link),
            trucky_link = VALUES(trucky_link),
            date = VALUES(date),
            heure = VALUES(heure),
            parcours = VALUES(parcours),
            description = VALUES(description),
            rules = VALUES(rules),
            serveur = VALUES(serveur),
            marchandise = VALUES(marchandise)
    ");
    
    $stmt->execute([
        intval($input['id']),
        $input['pseudo'],
        $input['discord'],
        $input['tmp_link'] ?? null,
        $input['truckbook_link'] ?? null,
        $input['trucky_link'] ?? null,
        $input['date'],
        $input['heure'],
        $input['parcours'],
        $input['description'],
        $input['rules'] ?? null,
        $input['serveur'] ?? null,
        $input['marchandise'] ?? null
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Convoi sauvegardé avec succès',
        'convoi_id' => intval($input['id'])
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur lors de la sauvegarde du convoi: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la sauvegarde du convoi']);
}

?>
