<?php
// ========================================
// API - SUPPRIMER UN CHAUFFEUR
// ========================================

// Activer les erreurs pour debug (à retirer en production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Ne pas afficher dans le HTML
ini_set('log_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Vérifier que config.php existe
if (!file_exists('config.php')) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Fichier config.php manquant',
        'debug' => 'Créez le fichier api/config.php'
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception('Impossible de se connecter à la base de données');
    }
    
    // Récupérer l'ID du chauffeur à supprimer
    $chauffeur_id = null;
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Méthode DELETE : ID dans l'URL
        $chauffeur_id = isset($_GET['id']) ? intval($_GET['id']) : null;
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Méthode POST : ID dans le body JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $chauffeur_id = isset($input['id']) ? intval($input['id']) : null;
    }
    
    if (!$chauffeur_id) {
        throw new Exception('ID du chauffeur requis');
    }
    
    // Vérifier que le chauffeur existe et récupérer ses infos avant suppression
    $stmt = $pdo->prepare("
        SELECT 
            c.id,
            c.pseudo,
            c.avatar_url,
            cs.livraisons,
            cs.kilometres,
            (SELECT COUNT(*) FROM chauffeur_badges WHERE chauffeur_id = c.id) as nombre_badges
        FROM chauffeurs c
        LEFT JOIN chauffeur_stats cs ON c.id = cs.chauffeur_id
        WHERE c.id = :id
    ");
    $stmt->execute(['id' => $chauffeur_id]);
    $chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$chauffeur) {
        throw new Exception('Chauffeur non trouvé');
    }
    
    // Supprimer le chauffeur (les stats et badges seront supprimés automatiquement grâce à ON DELETE CASCADE)
    $stmt = $pdo->prepare("DELETE FROM chauffeurs WHERE id = :id");
    $stmt->execute(['id' => $chauffeur_id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Chauffeur supprimé avec succès',
        'data' => $chauffeur
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de base de données',
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
