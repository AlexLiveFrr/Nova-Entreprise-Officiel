<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

// Vérifier si un fichier a été uploadé
if (!isset($_FILES['csv_file'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Aucun fichier CSV fourni'
    ]);
    exit;
}

$file = $_FILES['csv_file'];

// Vérifier les erreurs d'upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de l\'upload du fichier'
    ]);
    exit;
}

// Vérifier l'extension
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'csv') {
    echo json_encode([
        'success' => false,
        'message' => 'Le fichier doit être au format CSV'
    ]);
    exit;
}

try {
    $pdo = getDBConnection();
    
    // Ouvrir le fichier CSV
    $handle = fopen($file['tmp_name'], 'r');
    if ($handle === false) {
        throw new Exception('Impossible d\'ouvrir le fichier CSV');
    }
    
    // Lire l'en-tête
    $header = fgetcsv($handle, 0, ',');
    if ($header === false) {
        throw new Exception('Fichier CSV vide ou invalide');
    }
    
    // Mapper les colonnes (basé sur le CSV TrucksBook)
    $columnMap = [];
    foreach ($header as $index => $column) {
        $columnMap[trim($column)] = $index;
    }
    
    // Statistiques d'import
    $stats = [
        'total_lignes' => 0,
        'chauffeurs_traites' => [],
        'erreurs' => []
    ];
    
    // Lire chaque ligne
    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        $stats['total_lignes']++;
        
        try {
            // Extraire les données
            $nom = isset($columnMap['Nom']) ? trim($data[$columnMap['Nom']]) : '';
            $jeu = isset($columnMap['Jeu']) ? trim($data[$columnMap['Jeu']]) : '';
            
            // Nettoyer la distance (retirer espaces et remplacer virgule par point)
            $distance_raw = isset($columnMap['Distance planifiée']) ? $data[$columnMap['Distance planifiée']] : '0';
            $distance = floatval(str_replace([' ', ','], ['', '.'], $distance_raw));
            
            $temps_reel = isset($columnMap['Temps pris (réel) [s]']) ? intval($data[$columnMap['Temps pris (réel) [s]']]) : 0;
            
            // Nettoyer les dommages
            $dommages_raw = isset($columnMap['Dommages']) ? $data[$columnMap['Dommages']] : '0';
            $dommages = floatval(str_replace([' ', ','], ['', '.'], $dommages_raw));
            
            if (empty($nom)) {
                continue; // Ignorer les lignes sans nom
            }
            
            // Initialiser les stats du chauffeur si nécessaire
            if (!isset($stats['chauffeurs_traites'][$nom])) {
                $stats['chauffeurs_traites'][$nom] = [
                    'livraisons' => 0,
                    'kilometres' => 0,
                    'heures_jeu' => 0,
                    'accidents' => 0,
                    'jeu' => $jeu
                ];
            }
            
            // Accumuler les statistiques
            $stats['chauffeurs_traites'][$nom]['livraisons']++;
            $stats['chauffeurs_traites'][$nom]['kilometres'] += $distance;
            $stats['chauffeurs_traites'][$nom]['heures_jeu'] += ($temps_reel / 3600); // Convertir secondes en heures
            
            // Compter les accidents (si dommages > 0)
            if ($dommages > 0) {
                $stats['chauffeurs_traites'][$nom]['accidents']++;
            }
            
        } catch (Exception $e) {
            $stats['erreurs'][] = "Ligne {$stats['total_lignes']}: " . $e->getMessage();
        }
    }
    
    fclose($handle);
    
    // Mettre à jour la base de données
    $chauffeurs_mis_a_jour = 0;
    $chauffeurs_non_trouves = [];
    
    foreach ($stats['chauffeurs_traites'] as $pseudo => $data) {
        // Chercher le chauffeur dans la base
        $stmt = $pdo->prepare("SELECT id FROM chauffeurs WHERE pseudo = ? OR LOWER(pseudo) = LOWER(?)");
        $stmt->execute([$pseudo, $pseudo]);
        $chauffeur = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($chauffeur) {
            // Mettre à jour les statistiques
            $stmt = $pdo->prepare("
                UPDATE chauffeur_stats 
                SET livraisons = ?, 
                    kilometres = ?,
                    heures_jeu = ?,
                    accidents = ?
                WHERE chauffeur_id = ?
            ");
            $stmt->execute([
                $data['livraisons'],
                round($data['kilometres']),
                round($data['heures_jeu']),
                $data['accidents'],
                $chauffeur['id']
            ]);
            
            $chauffeurs_mis_a_jour++;
        } else {
            $chauffeurs_non_trouves[] = $pseudo;
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Import terminé avec succès',
        'stats' => [
            'lignes_lues' => $stats['total_lignes'],
            'chauffeurs_detectes' => count($stats['chauffeurs_traites']),
            'chauffeurs_mis_a_jour' => $chauffeurs_mis_a_jour,
            'chauffeurs_non_trouves' => $chauffeurs_non_trouves,
            'details' => $stats['chauffeurs_traites']
        ]
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur: ' . $e->getMessage()
    ]);
}
