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

// Essayer d'initialiser la base de données si elle n'existe pas
initDatabase();

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur de connexion à la base de données',
        'details' => 'Vérifiez votre configuration dans config.php'
    ]);
    exit;
}

try {
    $stmt = $pdo->query("
        SELECT 
            c.*,
            (SELECT COUNT(*) FROM photos WHERE convoi_id = c.id) as photo_count,
            (SELECT COUNT(*) FROM participations WHERE convoi_id = c.id AND statut = 'participe') as count_participe,
            (SELECT COUNT(*) FROM participations WHERE convoi_id = c.id AND statut = 'incertain') as count_incertain,
            (SELECT COUNT(*) FROM participations WHERE convoi_id = c.id AND type_participant = 'joueur') as count_joueurs,
            (SELECT COUNT(*) FROM participations WHERE convoi_id = c.id AND type_participant = 'entreprise') as count_entreprises
        FROM convois c
        ORDER BY c.date_creation DESC
    ");
    
    $convois = $stmt->fetchAll();
    
    // Convertir les dates en format ISO pour JavaScript
    foreach ($convois as &$convoi) {
        $convoi['id'] = intval($convoi['id']);
        $convoi['photoCount'] = intval($convoi['photo_count']);
        $convoi['countParticipe'] = intval($convoi['count_participe']);
        $convoi['countIncertain'] = intval($convoi['count_incertain']);
        $convoi['countJoueurs'] = intval($convoi['count_joueurs']);
        $convoi['countEntreprises'] = intval($convoi['count_entreprises']);
        unset($convoi['photo_count'], $convoi['count_participe'], $convoi['count_incertain'], $convoi['count_joueurs'], $convoi['count_entreprises']);
    }
    
    echo json_encode([
        'success' => true,
        'convois' => $convois,
        'count' => count($convois)
    ]);
    
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des convois: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des convois']);
}

?>
