<?php
// Configuration de la base de données
// Site : https://transport.fr - Hébergé sur OVH

// ============================================
// CONFIGURATION POUR SERVEUR OVH
// ============================================
define('DB_HOST', 'transcs.mysql.db');     // Adresse du serveur OVH
define('DB_NAME', 'transcs');               // Nom de la base
define('DB_USER', 'transcs');               // Nom d'utilisateur
define('DB_PASS', 'X1BN2Ygyub7JPgaDRdA6HBxXMrg'); // Mot de passe
define('DB_CHARSET', 'utf8mb4');

// Fonction de connexion à la base de données
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erreur de connexion BDD: " . $e->getMessage());
        return null;
    }
}
?>
