<?php
// ========================================
// API - RÉCUPÉRER LES CHAUFFEURS
// ========================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'config.php';

try {
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception('Impossible de se connecter à la base de données');
    }
    
    // Paramètres optionnels
    $chauffeur_id = isset($_GET['id']) ? intval($_GET['id']) : null;
    $statut = isset($_GET['statut']) ? $_GET['statut'] : 'actif';
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    if ($chauffeur_id) {
        // Récupérer un chauffeur spécifique avec toutes ses infos
        $stmt = $pdo->prepare("
            SELECT 
                c.*,
                cs.livraisons,
                cs.kilometres,
                cs.heures_jeu,
                cs.convois_participes,
                cs.accidents,
                cs.livraisons_nuit,
                cs.derniere_livraison,
                cs.derniere_mise_a_jour,
                r.nom as rang_nom,
                r.icone as rang_icone,
                r.niveau as rang_niveau,
                r.couleur as rang_couleur,
                (SELECT COUNT(*) FROM chauffeur_badges WHERE chauffeur_id = c.id) as nombre_badges
            FROM chauffeurs c
            LEFT JOIN chauffeur_stats cs ON c.id = cs.chauffeur_id
            LEFT JOIN rangs r ON cs.livraisons >= r.livraisons_requises
            WHERE c.id = :id
            ORDER BY r.niveau DESC
            LIMIT 1
        ");
        $stmt->execute(['id' => $chauffeur_id]);
        $chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($chauffeur) {
            // Récupérer les badges du chauffeur
            $stmt_badges = $pdo->prepare("
                SELECT 
                    b.code,
                    b.nom,
                    b.description,
                    b.icone,
                    b.couleur,
                    cb.date_obtention
                FROM chauffeur_badges cb
                INNER JOIN badges b ON cb.badge_id = b.id
                WHERE cb.chauffeur_id = :id AND b.actif = TRUE
                ORDER BY cb.date_obtention DESC
            ");
            $stmt_badges->execute(['id' => $chauffeur_id]);
            $chauffeur['badges'] = $stmt_badges->fetchAll(PDO::FETCH_ASSOC);
            
            // Calculer le prochain rang
            $stmt_next = $pdo->prepare("
                SELECT nom, icone, livraisons_requises
                FROM rangs
                WHERE livraisons_requises > :livraisons
                ORDER BY niveau ASC
                LIMIT 1
            ");
            $stmt_next->execute(['livraisons' => $chauffeur['livraisons']]);
            $chauffeur['prochain_rang'] = $stmt_next->fetch(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $chauffeur
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Chauffeur non trouvé'
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
        // Récupérer la liste des chauffeurs (classement)
        $where = $statut ? "WHERE c.statut = :statut" : "";
        
        $stmt = $pdo->prepare("
            SELECT 
                c.id,
                c.pseudo,
                c.avatar_url,
                c.statut,
                cs.livraisons,
                cs.kilometres,
                cs.heures_jeu,
                cs.convois_participes,
                (SELECT r.nom FROM rangs r WHERE cs.livraisons >= r.livraisons_requises ORDER BY r.niveau DESC LIMIT 1) as rang_nom,
                (SELECT r.icone FROM rangs r WHERE cs.livraisons >= r.livraisons_requises ORDER BY r.niveau DESC LIMIT 1) as rang_icone,
                (SELECT r.niveau FROM rangs r WHERE cs.livraisons >= r.livraisons_requises ORDER BY r.niveau DESC LIMIT 1) as rang_niveau,
                (SELECT COUNT(*) FROM chauffeur_badges WHERE chauffeur_id = c.id) as nombre_badges
            FROM chauffeurs c
            LEFT JOIN chauffeur_stats cs ON c.id = cs.chauffeur_id
            $where
            ORDER BY cs.livraisons DESC
            LIMIT :limit OFFSET :offset
        ");
        
        if ($statut) {
            $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $chauffeurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Compter le total
        $count_stmt = $pdo->prepare("SELECT COUNT(*) as total FROM chauffeurs c $where");
        if ($statut) {
            $count_stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
        }
        $count_stmt->execute();
        $total = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        echo json_encode([
            'success' => true,
            'data' => $chauffeurs,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset
        ], JSON_UNESCAPED_UNICODE);
    }
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de connexion à la base de données',
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
