<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer la requête preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config.php';

initDatabase();

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

// GET : Récupérer les participations d'un convoi
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['convoi_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de convoi manquant']);
        exit;
    }
    
    $convoi_id = intval($_GET['convoi_id']);
    
    try {
        $stmt = $pdo->prepare("
            SELECT pseudo, discord, statut, type_participant, nom_entreprise, lien_vtc, date_inscription 
            FROM participations 
            WHERE convoi_id = ? 
            ORDER BY date_inscription ASC
        ");
        $stmt->execute([$convoi_id]);
        $participations = $stmt->fetchAll();
        
        $participe = array_filter($participations, fn($p) => $p['statut'] === 'participe');
        $incertain = array_filter($participations, fn($p) => $p['statut'] === 'incertain');
        $joueurs = array_filter($participations, fn($p) => $p['type_participant'] === 'joueur');
        $entreprises = array_filter($participations, fn($p) => $p['type_participant'] === 'entreprise');
        
        echo json_encode([
            'success' => true,
            'participations' => array_values($participations),
            'count_participe' => count($participe),
            'count_incertain' => count($incertain),
            'count_joueurs' => count($joueurs),
            'count_entreprises' => count($entreprises),
            'total' => count($participations)
        ]);
    } catch (PDOException $e) {
        error_log("Erreur participations GET: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la récupération des participations']);
    }
    exit;
}

// POST : Ajouter ou mettre à jour une participation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['convoi_id']) || !isset($input['pseudo']) || !isset($input['discord'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Données manquantes (convoi_id, pseudo, discord requis)']);
        exit;
    }
    
    $convoi_id = intval($input['convoi_id']);
    $pseudo = trim($input['pseudo']);
    $discord = trim($input['discord']);
    $statut = isset($input['statut']) && in_array($input['statut'], ['participe', 'incertain']) 
              ? $input['statut'] 
              : 'participe';
    $type_participant = isset($input['type_participant']) && in_array($input['type_participant'], ['joueur', 'entreprise']) 
              ? $input['type_participant'] 
              : 'joueur';
    $nom_entreprise = ($type_participant === 'entreprise' && !empty($input['nom_entreprise'])) 
              ? trim($input['nom_entreprise']) 
              : null;
    $lien_vtc = ($type_participant === 'entreprise' && !empty($input['lien_vtc'])) 
              ? trim($input['lien_vtc']) 
              : null;
    
    if (empty($pseudo) || empty($discord)) {
        http_response_code(400);
        echo json_encode(['error' => 'Pseudo et Discord ne peuvent pas être vides']);
        exit;
    }
    
    if ($type_participant === 'entreprise' && empty($nom_entreprise)) {
        http_response_code(400);
        echo json_encode(['error' => 'Le nom de l\'entreprise/VTC est obligatoire']);
        exit;
    }
    
    try {
        // Vérifier que le convoi existe
        $check = $pdo->prepare("SELECT id FROM convois WHERE id = ?");
        $check->execute([$convoi_id]);
        if (!$check->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Convoi introuvable']);
            exit;
        }
        
        // Insérer ou mettre à jour la participation
        $stmt = $pdo->prepare("
            INSERT INTO participations (convoi_id, pseudo, discord, statut, type_participant, nom_entreprise, lien_vtc, date_inscription)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
                discord = VALUES(discord),
                statut = VALUES(statut),
                type_participant = VALUES(type_participant),
                nom_entreprise = VALUES(nom_entreprise),
                lien_vtc = VALUES(lien_vtc),
                date_inscription = NOW()
        ");
        $stmt->execute([$convoi_id, $pseudo, $discord, $statut, $type_participant, $nom_entreprise, $lien_vtc]);
        
        // Récupérer le nombre total de participants
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM participations WHERE convoi_id = ? AND statut = 'participe'");
        $countStmt->execute([$convoi_id]);
        $count = $countStmt->fetch()['total'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Participation enregistrée !',
            'count_participe' => intval($count)
        ]);
    } catch (PDOException $e) {
        error_log("Erreur participation POST: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de l\'enregistrement de la participation']);
    }
    exit;
}

// DELETE : Retirer sa participation
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['convoi_id']) || !isset($input['pseudo'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Données manquantes (convoi_id, pseudo requis)']);
        exit;
    }
    
    $convoi_id = intval($input['convoi_id']);
    $pseudo = trim($input['pseudo']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM participations WHERE convoi_id = ? AND pseudo = ?");
        $stmt->execute([$convoi_id, $pseudo]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Participation retirée',
            'deleted' => $stmt->rowCount() > 0
        ]);
    } catch (PDOException $e) {
        error_log("Erreur participation DELETE: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la suppression de la participation']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Méthode non autorisée']);
?>
