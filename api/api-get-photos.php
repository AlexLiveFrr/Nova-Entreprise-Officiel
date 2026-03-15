<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer la requête preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config.php';

// Initialiser la base de données si nécessaire
initDatabase();

if (!isset($_GET['convoi_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de convoi manquant']);
    exit;
}

$convoi_id = intval($_GET['convoi_id']);

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT photo_data, photo_type FROM photos WHERE convoi_id = ? ORDER BY id ASC");
    $stmt->execute([$convoi_id]);
    $photos = $stmt->fetchAll();
    
    $photosBase64 = [];
    foreach ($photos as $photo) {
        $base64 = base64_encode($photo['photo_data']);
        $photosBase64[] = 'data:image/' . $photo['photo_type'] . ';base64,' . $base64;
    }
    
    echo json_encode([
        'success' => true,
        'photos' => $photosBase64,
        'count' => count($photosBase64)
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des photos: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des photos']);
}

?>
