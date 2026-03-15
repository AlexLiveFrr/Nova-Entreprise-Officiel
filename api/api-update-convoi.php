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

initDatabase();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// L'ID est obligatoire
if (!isset($input['id']) || empty($input['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID du convoi requis']);
    exit;
}

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    // Vérifier que le convoi existe
    $check = $pdo->prepare("SELECT id FROM convois WHERE id = ?");
    $check->execute([intval($input['id'])]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Convoi introuvable']);
        exit;
    }

    // Construire la requête UPDATE dynamiquement
    $fields = [];
    $values = [];
    
    $allowedFields = [
        'pseudo', 'discord', 'tmp_link', 'truckbook_link', 'trucky_link',
        'date', 'heure', 'parcours', 'description', 'rules', 'serveur', 'marchandise'
    ];
    
    foreach ($allowedFields as $field) {
        if (array_key_exists($field, $input)) {
            $fields[] = "$field = ?";
            $values[] = $input[$field] !== '' ? $input[$field] : null;
        }
    }
    
    if (empty($fields)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Aucun champ à mettre à jour']);
        exit;
    }
    
    $values[] = intval($input['id']);
    
    $sql = "UPDATE convois SET " . implode(', ', $fields) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    
    echo json_encode([
        'success' => true,
        'message' => 'Convoi mis à jour avec succès',
        'convoi_id' => intval($input['id'])
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur update convoi: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur lors de la mise à jour']);
}
?>
