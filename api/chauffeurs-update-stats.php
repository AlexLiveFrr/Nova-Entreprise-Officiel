<?php
// ========================================
// API - METTRE À JOUR LES STATS D'UN CHAUFFEUR
// ========================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

// Gestion des requêtes OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception('Impossible de se connecter à la base de données');
    }
    
    // Récupérer les données JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['chauffeur_id'])) {
        throw new Exception('ID du chauffeur requis');
    }
    
    $chauffeur_id = intval($input['chauffeur_id']);
    $mis_a_jour_par = isset($input['mis_a_jour_par']) ? $input['mis_a_jour_par'] : 'admin';
    
    // Vérifier que le chauffeur existe
    $stmt = $pdo->prepare("SELECT id FROM chauffeurs WHERE id = :id");
    $stmt->execute(['id' => $chauffeur_id]);
    if (!$stmt->fetch()) {
        throw new Exception('Chauffeur non trouvé');
    }
    
    // Récupérer les stats actuelles
    $stmt = $pdo->prepare("SELECT * FROM chauffeur_stats WHERE chauffeur_id = :id");
    $stmt->execute(['id' => $chauffeur_id]);
    $stats_avant = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Préparer les données à mettre à jour
    $updates = [];
    $params = ['chauffeur_id' => $chauffeur_id];
    
    if (isset($input['livraisons'])) {
        $updates[] = "livraisons = :livraisons";
        $params['livraisons'] = intval($input['livraisons']);
    }
    
    if (isset($input['kilometres'])) {
        $updates[] = "kilometres = :kilometres";
        $params['kilometres'] = intval($input['kilometres']);
    }
    
    if (isset($input['heures_jeu'])) {
        $updates[] = "heures_jeu = :heures_jeu";
        $params['heures_jeu'] = intval($input['heures_jeu']);
    }
    
    if (isset($input['convois_participes'])) {
        $updates[] = "convois_participes = :convois_participes";
        $params['convois_participes'] = intval($input['convois_participes']);
    }
    
    if (isset($input['accidents'])) {
        $updates[] = "accidents = :accidents";
        $params['accidents'] = intval($input['accidents']);
    }
    
    if (isset($input['livraisons_nuit'])) {
        $updates[] = "livraisons_nuit = :livraisons_nuit";
        $params['livraisons_nuit'] = intval($input['livraisons_nuit']);
    }
    
    if (isset($input['derniere_livraison'])) {
        $updates[] = "derniere_livraison = :derniere_livraison";
        $params['derniere_livraison'] = $input['derniere_livraison'];
    }
    
    if (empty($updates)) {
        throw new Exception('Aucune donnée à mettre à jour');
    }
    
    // Mettre à jour les stats
    $sql = "UPDATE chauffeur_stats SET " . implode(', ', $updates) . " WHERE chauffeur_id = :chauffeur_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    // Enregistrer dans l'historique
    $stmt = $pdo->prepare("
        INSERT INTO historique_stats 
        (chauffeur_id, livraisons_avant, livraisons_apres, kilometres_avant, kilometres_apres, mis_a_jour_par)
        VALUES (:chauffeur_id, :livraisons_avant, :livraisons_apres, :kilometres_avant, :kilometres_apres, :mis_a_jour_par)
    ");
    $stmt->execute([
        'chauffeur_id' => $chauffeur_id,
        'livraisons_avant' => $stats_avant['livraisons'],
        'livraisons_apres' => isset($params['livraisons']) ? $params['livraisons'] : $stats_avant['livraisons'],
        'kilometres_avant' => $stats_avant['kilometres'],
        'kilometres_apres' => isset($params['kilometres']) ? $params['kilometres'] : $stats_avant['kilometres'],
        'mis_a_jour_par' => $mis_a_jour_par
    ]);
    
    // Récupérer les stats mises à jour
    $stmt = $pdo->prepare("
        SELECT 
            c.*,
            cs.*,
            r.nom as rang_nom,
            r.icone as rang_icone
        FROM chauffeurs c
        LEFT JOIN chauffeur_stats cs ON c.id = cs.chauffeur_id
        LEFT JOIN rangs r ON cs.livraisons >= r.livraisons_requises
        WHERE c.id = :id
        ORDER BY r.niveau DESC
        LIMIT 1
    ");
    $stmt->execute(['id' => $chauffeur_id]);
    $chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Récupérer les nouveaux badges obtenus
    $stmt = $pdo->prepare("
        SELECT 
            b.nom,
            b.icone,
            cb.date_obtention
        FROM chauffeur_badges cb
        INNER JOIN badges b ON cb.badge_id = b.id
        WHERE cb.chauffeur_id = :id
        AND cb.date_obtention >= NOW() - INTERVAL 1 MINUTE
        ORDER BY cb.date_obtention DESC
    ");
    $stmt->execute(['id' => $chauffeur_id]);
    $nouveaux_badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'message' => 'Statistiques mises à jour avec succès',
        'data' => $chauffeur,
        'nouveaux_badges' => $nouveaux_badges
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
