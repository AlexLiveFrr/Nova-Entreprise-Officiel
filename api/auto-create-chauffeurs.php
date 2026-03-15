<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

// Liste des chauffeurs à créer (depuis votre CSV)
$chauffeurs_to_create = [
    'StanLait',
    'Romain67',
    'Damien Pinel',
    'Dudul17',
    'DEGAGE DE LA',
    'Nono XVI',
    'Jason_du77',
    '-XeNusT-',
    'Scott_Royal',
    'morgane971',
    'kevinx91x',
    'Zindien',
    'Dorian38',
    'PRINCE GUILLAUM',
    's7',
    'CFR | Corentin',
    'taka-san',
    'Bywo',
    'fortag',
    'Zyroxx',
    'ttlou85',
    'Darckside',
    'ZolaDinho',
    'RTZ91150',
    'tombiboy',
    'Nathael494',
    'alann62',
    'kurky',
    'Donovan_45',
    'maoam54',
    'Artemy 35rus',
    'AlexLiveFr',
    'Miihawk',
    'Biggaigris',
    'Pandouix',
    'ylian',
    'aurel27',
    'Miss Tigz',
    'Bad6.3',
    'mannogamer96',
    'jose coimbra',
    'EspoirLeCongolé',
    'Vnr_Poluxx',
    'Binouze74'
];

try {
    $pdo = getDBConnection();
    
    $created = 0;
    $already_exists = 0;
    $errors = [];
    
    foreach ($chauffeurs_to_create as $pseudo) {
        try {
            // Vérifier si le chauffeur existe déjà
            $stmt = $pdo->prepare("SELECT id FROM chauffeurs WHERE pseudo = ? OR LOWER(pseudo) = LOWER(?)");
            $stmt->execute([$pseudo, $pseudo]);
            
            if ($stmt->fetch()) {
                $already_exists++;
                continue;
            }
            
            // Créer le chauffeur
            $stmt = $pdo->prepare("
                INSERT INTO chauffeurs (pseudo, avatar_url, statut, date_inscription) 
                VALUES (?, ?, 'actif', NOW())
            ");
            
            // Générer un avatar automatique
            $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($pseudo) . "&size=256&background=2563eb&color=fff&bold=true";
            
            $stmt->execute([$pseudo, $avatar_url]);
            $chauffeur_id = $pdo->lastInsertId();
            
            // Créer les statistiques initiales
            $stmt = $pdo->prepare("
                INSERT INTO chauffeur_stats (chauffeur_id, livraisons, kilometres, heures_jeu, convois_participes, accidents, livraisons_nuit) 
                VALUES (?, 0, 0, 0, 0, 0, 0)
            ");
            $stmt->execute([$chauffeur_id]);
            
            $created++;
            
        } catch (Exception $e) {
            $errors[] = "Erreur pour $pseudo: " . $e->getMessage();
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Création automatique terminée',
        'stats' => [
            'total_a_creer' => count($chauffeurs_to_create),
            'crees' => $created,
            'deja_existants' => $already_exists,
            'erreurs' => count($errors)
        ],
        'details_erreurs' => $errors
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
