<?php
// ========================================
// DIAGNOSTIC COMPLET DES ERREURS
// ========================================

// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Diagnostic Complet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-black text-yellow-400 mb-8">🔍 Diagnostic Complet</h1>
        <div class="space-y-4">
';

// Test 1 : Vérifier config.php
echo '<div class="bg-slate-800 p-4 rounded-lg">';
echo '<h2 class="text-xl font-bold text-blue-400 mb-2">1️⃣ Vérification config.php</h2>';
try {
    require_once 'config.php';
    echo '<p class="text-green-400">✅ config.php chargé</p>';
    echo '<p class="text-gray-400">Host: ' . DB_HOST . '</p>';
    echo '<p class="text-gray-400">Database: ' . DB_NAME . '</p>';
    echo '<p class="text-gray-400">User: ' . DB_USER . '</p>';
} catch (Exception $e) {
    echo '<p class="text-red-400">❌ Erreur: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// Test 2 : Connexion à la base
echo '<div class="bg-slate-800 p-4 rounded-lg">';
echo '<h2 class="text-xl font-bold text-blue-400 mb-2">2️⃣ Connexion Base de Données</h2>';
try {
    $pdo = getDBConnection();
    if ($pdo) {
        echo '<p class="text-green-400">✅ Connexion réussie</p>';
        
        // Test 3 : Vérifier les tables
        echo '<h3 class="text-lg font-bold text-blue-300 mt-4 mb-2">3️⃣ Tables existantes</h3>';
        $tables = ['chauffeurs', 'chauffeur_stats', 'badges', 'chauffeur_badges', 'rangs'];
        foreach ($tables as $table) {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() > 0) {
                echo '<p class="text-green-400">✅ ' . $table . '</p>';
            } else {
                echo '<p class="text-red-400">❌ ' . $table . ' (manquante)</p>';
            }
        }
    } else {
        echo '<p class="text-red-400">❌ Impossible de se connecter</p>';
    }
} catch (Exception $e) {
    echo '<p class="text-red-400">❌ Erreur: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// Test 4 : Vérifier les fichiers API
echo '<div class="bg-slate-800 p-4 rounded-lg">';
echo '<h2 class="text-xl font-bold text-blue-400 mb-2">4️⃣ Fichiers API</h2>';
$api_files = [
    'test-connection.php',
    'chauffeurs-get.php',
    'chauffeurs-add.php',
    'chauffeurs-update-stats.php',
    'install-simple.php'
];
foreach ($api_files as $file) {
    if (file_exists($file)) {
        echo '<p class="text-green-400">✅ ' . $file . '</p>';
    } else {
        echo '<p class="text-red-400">❌ ' . $file . ' (manquant)</p>';
    }
}
echo '</div>';

// Test 5 : Informations PHP
echo '<div class="bg-slate-800 p-4 rounded-lg">';
echo '<h2 class="text-xl font-bold text-blue-400 mb-2">5️⃣ Configuration PHP</h2>';
echo '<p class="text-gray-400">Version PHP: ' . phpversion() . '</p>';
echo '<p class="text-gray-400">Extensions PDO: ' . (extension_loaded('pdo') ? '✅' : '❌') . '</p>';
echo '<p class="text-gray-400">Extensions PDO MySQL: ' . (extension_loaded('pdo_mysql') ? '✅' : '❌') . '</p>';
echo '</div>';

// Boutons d'action
echo '<div class="bg-blue-900/30 border-2 border-blue-600 rounded-xl p-6 mt-8">';
echo '<h2 class="text-2xl font-bold text-blue-400 mb-4">🚀 Actions</h2>';
echo '<div class="flex flex-col gap-3">';
echo '<a href="install-simple.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold text-center transition">📦 Installer les tables</a>';
echo '<a href="test-connection.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold text-center transition">🔗 Tester la connexion (JSON)</a>';
echo '<a href="../diagnostic-truckbook.html" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-bold text-center transition">🔍 Diagnostic complet</a>';
echo '</div>';
echo '</div>';

echo '
        </div>
    </div>
</body>
</html>';
?>
