<?php
// ========================================
// API - SUPPRIMER TOUS LES CHAUFFEURS
// ========================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = getDBConnection();
    
    if (!$pdo) {
        throw new Exception('Impossible de se connecter à la base de données');
    }
    
    // Compter le nombre de chauffeurs avant suppression
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM chauffeurs");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($count == 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Aucun chauffeur à supprimer',
            'deleted' => 0
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Supprimer tous les chauffeurs
    // Les statistiques et badges seront supprimés automatiquement grâce à ON DELETE CASCADE
    $stmt = $pdo->prepare("DELETE FROM chauffeurs");
    $stmt->execute();
    
    echo json_encode([
        'success' => true,
        'message' => 'Tous les chauffeurs ont été supprimés',
        'deleted' => $count
    ], JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de base de données: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
