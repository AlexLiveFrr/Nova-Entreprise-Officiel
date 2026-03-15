<?php
// ========================================
// INSTALLATION AUTOMATIQUE DU SYSTÈME TRUCKBOOK
// ========================================

header('Content-Type: text/html; charset=utf-8');

require_once 'config.php';

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Installation Système TruckBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-black text-yellow-400 mb-8">🚀 Installation Système TruckBook</h1>
';

try {
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception('Impossible de se connecter à la base de données');
    }

    echo '<div class="space-y-4">';

    // Lire le fichier SQL
    $sqlFile = __DIR__ . '/db-setup-truckbook.sql';
    
    if (!file_exists($sqlFile)) {
        throw new Exception('Fichier db-setup-truckbook.sql non trouvé');
    }

    $sql = file_get_contents($sqlFile);
    
    // Séparer les requêtes
    $queries = explode(';', $sql);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        
        // Ignorer les commentaires et les lignes vides
        if (empty($query) || strpos($query, '--') === 0 || strpos($query, '/*') === 0) {
            continue;
        }
        
        try {
            $pdo->exec($query);
            $success_count++;
            echo '<div class="bg-green-900/30 border-2 border-green-600 rounded-lg p-4">';
            echo '<p class="font-bold">✅ Requête exécutée</p>';
            echo '<pre class="text-xs text-gray-400 mt-2">' . htmlspecialchars(substr($query, 0, 100)) . '...</pre>';
            echo '</div>';
        } catch (PDOException $e) {
            // Ignorer les erreurs "table already exists" ou "duplicate key"
            if (strpos($e->getMessage(), 'already exists') !== false || 
                strpos($e->getMessage(), 'Duplicate') !== false) {
                echo '<div class="bg-yellow-900/30 border-2 border-yellow-600 rounded-lg p-4">';
                echo '<p class="font-bold">⚠️ Déjà existant (ignoré)</p>';
                echo '<pre class="text-xs text-gray-400 mt-2">' . htmlspecialchars(substr($query, 0, 100)) . '...</pre>';
                echo '</div>';
            } else {
                $error_count++;
                echo '<div class="bg-red-900/30 border-2 border-red-600 rounded-lg p-4">';
                echo '<p class="font-bold">❌ Erreur</p>';
                echo '<p class="text-sm text-red-400">' . htmlspecialchars($e->getMessage()) . '</p>';
                echo '<pre class="text-xs text-gray-400 mt-2">' . htmlspecialchars(substr($query, 0, 100)) . '...</pre>';
                echo '</div>';
            }
        }
    }
    
    echo '</div>';
    
    // Résumé
    echo '<div class="mt-8 bg-blue-900/30 border-2 border-blue-600 rounded-xl p-6">';
    echo '<h2 class="text-2xl font-bold text-yellow-400 mb-4">📊 Résumé</h2>';
    echo '<p class="text-lg">✅ Requêtes réussies : ' . $success_count . '</p>';
    echo '<p class="text-lg">❌ Erreurs : ' . $error_count . '</p>';
    echo '</div>';
    
    // Vérification finale
    echo '<div class="mt-8 bg-slate-800 rounded-xl p-6">';
    echo '<h2 class="text-2xl font-bold text-yellow-400 mb-4">🔍 Vérification des tables</h2>';
    
    $tables = ['chauffeurs', 'chauffeur_stats', 'badges', 'chauffeur_badges', 'rangs', 'historique_stats'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '" . $table . "'");
        if ($stmt->rowCount() > 0) {
            echo '<p class="text-green-400">✅ Table <code class="bg-slate-950 px-2 py-1 rounded">' . $table . '</code> existe</p>';
        } else {
            echo '<p class="text-red-400">❌ Table <code class="bg-slate-950 px-2 py-1 rounded">' . $table . '</code> manquante</p>';
        }
    }
    
    echo '</div>';
    
    // Instructions finales
    echo '<div class="mt-8 bg-green-900/30 border-2 border-green-600 rounded-xl p-6">';
    echo '<h2 class="text-2xl font-bold text-yellow-400 mb-4">🎉 Installation terminée !</h2>';
    echo '<p class="text-lg mb-4">Prochaines étapes :</p>';
    echo '<ol class="list-decimal list-inside space-y-2">';
    echo '<li>Ouvrir <a href="../diagnostic-truckbook.html" class="text-blue-400 underline">diagnostic-truckbook.html</a> pour vérifier</li>';
    echo '<li>Ouvrir <a href="../admin-chauffeurs.html" class="text-blue-400 underline">admin-chauffeurs.html</a> pour ajouter des chauffeurs</li>';
    echo '<li>Tester l\'ajout d\'un chauffeur</li>';
    echo '<li>Voir le résultat sur <a href="../equipe.html" class="text-blue-400 underline">equipe.html</a></li>';
    echo '</ol>';
    echo '</div>';
    
} catch (Exception $e) {
    echo '<div class="bg-red-900/30 border-2 border-red-600 rounded-xl p-6">';
    echo '<h2 class="text-2xl font-bold text-red-400 mb-4">❌ Erreur d\'installation</h2>';
    echo '<p class="text-lg">' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<div class="mt-6">';
    echo '<h3 class="text-xl font-bold text-yellow-400 mb-2">Solutions :</h3>';
    echo '<ol class="list-decimal list-inside space-y-2">';
    echo '<li>Vérifier que WAMP est démarré (icône verte)</li>';
    echo '<li>Vérifier que MySQL est démarré</li>';
    echo '<li>Vérifier config.php</li>';
    echo '<li>Vérifier que la base de données existe</li>';
    echo '</ol>';
    echo '</div>';
    echo '</div>';
}

echo '
    </div>
</body>
</html>';
?>
