<?php
// ========================================
// API - AJOUTER UN NOUVEAU CHAUFFEUR
// ========================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

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
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validation
    if (!isset($input['pseudo']) || empty(trim($input['pseudo']))) {
        throw new Exception('Le pseudo est requis');
    }
    
    $pseudo = trim($input['pseudo']);
    $discord_id = isset($input['discord_id']) ? trim($input['discord_id']) : null;
    $steam_id = isset($input['steam_id']) ? trim($input['steam_id']) : null;
    $truckbook_url = isset($input['truckbook_url']) ? trim($input['truckbook_url']) : null;
    $truckersmp_id = isset($input['truckersmp_id']) ? intval($input['truckersmp_id']) : null;
    $avatar_url = isset($input['avatar_url']) ? trim($input['avatar_url']) : null;
    $role = isset($input['role']) ? $input['role'] : 'chauffeur';
    
    // Vérifier si le pseudo existe déjà
    $stmt = $pdo->prepare("SELECT id FROM chauffeurs WHERE pseudo = :pseudo");
    $stmt->execute(['pseudo' => $pseudo]);
    if ($stmt->fetch()) {
        throw new Exception('Ce pseudo existe déjà');
    }
    
    // Insérer le nouveau chauffeur
    $stmt = $pdo->prepare("
        INSERT INTO chauffeurs 
        (pseudo, discord_id, steam_id, truckbook_url, truckersmp_id, avatar_url, role)
        VALUES 
        (:pseudo, :discord_id, :steam_id, :truckbook_url, :truckersmp_id, :avatar_url, :role)
    ");
    
    $stmt->execute([
        'pseudo' => $pseudo,
        'discord_id' => $discord_id,
        'steam_id' => $steam_id,
        'truckbook_url' => $truckbook_url,
        'truckersmp_id' => $truckersmp_id,
        'avatar_url' => $avatar_url,
        'role' => $role
    ]);
    
    $chauffeur_id = $pdo->lastInsertId();
    
    // Récupérer le chauffeur créé
    $stmt = $pdo->prepare("
        SELECT 
            c.*,
            cs.livraisons,
            cs.kilometres,
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
    
    echo json_encode([
        'success' => true,
        'message' => 'Chauffeur ajouté avec succès',
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
