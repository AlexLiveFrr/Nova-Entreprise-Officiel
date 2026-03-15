<?php
// Configuration de la base de données
// Site : https://transport.fr - Hébergé sur OVH

// ============================================
// CHOIX : LOCAL (WAMP) ou DISTANT (Production OVH)
// ============================================
$ENVIRONMENT = 'distant'; // Mode DISTANT pour serveur OVH

if ($ENVIRONMENT === 'local') {
    // Configuration pour WAMP LOCAL
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'transcs');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // Configuration pour SERVEUR OVH
    define('DB_HOST', 'transcs.mysql.db');     // Adresse du serveur OVH
    define('DB_NAME', 'transcs');               // Nom de la base
    define('DB_USER', 'transcs');               // Nom d'utilisateur
    define('DB_PASS', 'X1BN2Ygyub7JPgaDRdA6HBxXMrg'); // Mot de passe
}

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

// Fonction pour créer les tables si elles n'existent pas
function initDatabase() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Créer la table convois
        $pdo->exec("CREATE TABLE IF NOT EXISTS convois (
            id BIGINT PRIMARY KEY,
            pseudo VARCHAR(100) NOT NULL,
            discord VARCHAR(100) NOT NULL,
            tmp_link TEXT,
            truckbook_link TEXT,
            trucky_link TEXT,
            date DATE NOT NULL,
            heure TIME NOT NULL,
            parcours VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            rules TEXT,
            serveur VARCHAR(100),
            marchandise VARCHAR(255),
            date_creation DATETIME NOT NULL,
            INDEX idx_date (date),
            INDEX idx_date_creation (date_creation)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        // Ajouter les colonnes serveur et marchandise si elles n'existent pas déjà
        try {
            $pdo->exec("ALTER TABLE convois ADD COLUMN serveur VARCHAR(100) DEFAULT NULL");
        } catch (PDOException $e) {
            // La colonne existe déjà, on ignore
        }
        try {
            $pdo->exec("ALTER TABLE convois ADD COLUMN marchandise VARCHAR(255) DEFAULT NULL");
        } catch (PDOException $e) {
            // La colonne existe déjà, on ignore
        }
        
        // Créer la table participations
        $pdo->exec("CREATE TABLE IF NOT EXISTS participations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            convoi_id BIGINT NOT NULL,
            pseudo VARCHAR(100) NOT NULL,
            discord VARCHAR(100) NOT NULL,
            statut ENUM('participe', 'incertain') NOT NULL DEFAULT 'participe',
            type_participant ENUM('joueur', 'entreprise') NOT NULL DEFAULT 'joueur',
            nom_entreprise VARCHAR(150) DEFAULT NULL,
            lien_vtc TEXT DEFAULT NULL,
            date_inscription DATETIME NOT NULL,
            FOREIGN KEY (convoi_id) REFERENCES convois(id) ON DELETE CASCADE,
            UNIQUE KEY unique_participation (convoi_id, pseudo),
            INDEX idx_convoi_part (convoi_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        // Ajouter les colonnes type_participant et nom_entreprise si elles n'existent pas
        try {
            $pdo->exec("ALTER TABLE participations ADD COLUMN type_participant ENUM('joueur', 'entreprise') NOT NULL DEFAULT 'joueur' AFTER statut");
        } catch (PDOException $e) {
            // La colonne existe déjà
        }
        try {
            $pdo->exec("ALTER TABLE participations ADD COLUMN nom_entreprise VARCHAR(150) DEFAULT NULL AFTER type_participant");
        } catch (PDOException $e) {
            // La colonne existe déjà
        }
        try {
            $pdo->exec("ALTER TABLE participations ADD COLUMN lien_vtc TEXT DEFAULT NULL AFTER nom_entreprise");
        } catch (PDOException $e) {
            // La colonne existe déjà
        }
        
        // Créer la table admins
        $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            date_creation DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        // Insérer le compte admin par défaut s'il n'existe pas
        $checkAdmin = $pdo->query("SELECT COUNT(*) FROM admins");
        if ($checkAdmin->fetchColumn() == 0) {
            $hash = password_hash('2024Admin', PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash, date_creation) VALUES (?, ?, NOW())");
            $stmt->execute(['admin', $hash]);
        }
        
        // Créer la table photos
        $pdo->exec("CREATE TABLE IF NOT EXISTS photos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            convoi_id BIGINT NOT NULL,
            photo_data LONGBLOB NOT NULL,
            photo_type VARCHAR(50) NOT NULL,
            date_upload DATETIME NOT NULL,
            FOREIGN KEY (convoi_id) REFERENCES convois(id) ON DELETE CASCADE,
            INDEX idx_convoi (convoi_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        return true;
    } catch (PDOException $e) {
        error_log("Erreur init BDD: " . $e->getMessage());
        return false;
    }
}

?>
