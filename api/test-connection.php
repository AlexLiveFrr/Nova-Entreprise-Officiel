<?php
// Test de connexion à la base de données
header('Content-Type: application/json; charset=utf-8');

require_once 'config.php';

try {
    $pdo = getDBConnection();
    
    if (!$pdo) {
        throw new PDOException('Impossible de se connecter à la base de données');
    }
    
    // Vérifier les tables
    $tables = ['chauffeurs', 'chauffeur_stats', 'badges', 'chauffeur_badges', 'rangs'];
    $tables_existantes = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '" . $table . "'");
        if ($stmt->rowCount() > 0) {
            $tables_existantes[] = $table;
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Connexion réussie !',
        'database' => DB_NAME,
        'tables_requises' => $tables,
        'tables_existantes' => $tables_existantes,
        'tables_manquantes' => array_diff($tables, $tables_existantes)
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur de connexion',
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>
