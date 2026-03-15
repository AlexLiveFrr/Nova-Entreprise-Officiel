<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer la requête preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config.php';

// Initialiser la base de données si nécessaire
initDatabase();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['convoi_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de convoi manquant']);
    exit;
}

$convoi_id = intval($input['convoi_id']);

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    // La suppression en cascade supprimera automatiquement les photos
    $stmt = $pdo->prepare("DELETE FROM convois WHERE id = ?");
    $stmt->execute([$convoi_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Convoi supprimé avec succès'
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Convoi introuvable']);
    }
    
} catch (PDOException $e) {
    error_log("Erreur lors de la suppression du convoi: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la suppression du convoi']);
}

?>
