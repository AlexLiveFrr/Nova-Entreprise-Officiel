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

if (!isset($input['convoi_id']) || !isset($input['photos'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Données manquantes']);
    exit;
}

$convoi_id = intval($input['convoi_id']);
$photos = $input['photos']; // Tableau de photos en Base64

if (!is_array($photos) || empty($photos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucune photo fournie']);
    exit;
}

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    $inserted = 0;
    foreach ($photos as $photoBase64) {
        // Décoder la photo Base64
        if (preg_match('/^data:image\/(\w+);base64,/', $photoBase64, $matches)) {
            $imageType = $matches[1];
            $imageData = base64_decode(substr($photoBase64, strpos($photoBase64, ',') + 1));
            
            // Vérifier la taille (max 5MB)
            if (strlen($imageData) > 5242880) {
                continue; // Ignorer les photos trop grandes
            }
            
            // Insérer la photo dans la base de données
            $stmt = $pdo->prepare("INSERT INTO photos (convoi_id, photo_data, photo_type, date_upload) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$convoi_id, $imageData, $imageType]);
            $inserted++;
        }
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => "$inserted photo(s) sauvegardée(s)",
        'count' => $inserted
    ]);
    
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Erreur lors de l'upload des photos: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la sauvegarde des photos']);
}

?>
