<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config.php';

// Initialiser la base de données si nécessaire
initDatabase();

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    // Supprimer les convois dont la date + heure + 30 minutes est passée
    // On compare : date + heure + INTERVAL 30 MINUTE < NOW()
    $stmt = $pdo->prepare("
        DELETE FROM convois 
        WHERE DATE_ADD(CONCAT(date, ' ', heure), INTERVAL 30 MINUTE) < NOW()
    ");
    
    $stmt->execute();
    $deletedCount = $stmt->rowCount();
    
    // Les photos seront supprimées automatiquement grâce à ON DELETE CASCADE
    
    $response = [
        'success' => true,
        'message' => "Nettoyage effectué",
        'deleted_count' => $deletedCount
    ];
    
    // Si des convois ont été supprimés, logger l'info
    if ($deletedCount > 0) {
        error_log("Nettoyage automatique: $deletedCount convoi(s) expiré(s) supprimé(s)");
    }
    
    echo json_encode($response);
    
} catch (PDOException $e) {
    error_log("Erreur lors du nettoyage des convois: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors du nettoyage des convois']);
}

?>
