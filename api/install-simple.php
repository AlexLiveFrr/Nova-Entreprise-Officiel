<?php
// ========================================
// INSTALLATION SIMPLE DU SYSTÈME TRUCKBOOK
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

    // Table chauffeurs
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table chauffeurs...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS chauffeurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pseudo VARCHAR(100) NOT NULL,
        discord_id VARCHAR(100),
        steam_id VARCHAR(100),
        truckbook_url VARCHAR(255),
        truckersmp_id INT,
        avatar_url VARCHAR(255),
        date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
        statut ENUM('actif', 'inactif', 'en_pause') DEFAULT 'actif',
        role ENUM('chauffeur', 'staff', 'admin') DEFAULT 'chauffeur',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_pseudo (pseudo)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table chauffeurs créée</p></div>';

    // Table chauffeur_stats
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table chauffeur_stats...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS chauffeur_stats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        chauffeur_id INT NOT NULL,
        livraisons INT DEFAULT 0,
        kilometres INT DEFAULT 0,
        heures_jeu INT DEFAULT 0,
        convois_participes INT DEFAULT 0,
        accidents INT DEFAULT 0,
        livraisons_nuit INT DEFAULT 0,
        derniere_livraison DATE,
        derniere_mise_a_jour DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id) ON DELETE CASCADE,
        UNIQUE KEY unique_chauffeur (chauffeur_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table chauffeur_stats créée</p></div>';

    // Table badges
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table badges...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS badges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(50) NOT NULL UNIQUE,
        nom VARCHAR(100) NOT NULL,
        description TEXT,
        icone VARCHAR(10),
        condition_type ENUM('livraisons', 'kilometres', 'convois', 'accidents', 'nuit', 'anciennete', 'special') NOT NULL,
        condition_valeur INT,
        couleur VARCHAR(50),
        ordre INT DEFAULT 0,
        actif BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table badges créée</p></div>';

    // Table chauffeur_badges
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table chauffeur_badges...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS chauffeur_badges (
        id INT AUTO_INCREMENT PRIMARY KEY,
        chauffeur_id INT NOT NULL,
        badge_id INT NOT NULL,
        date_obtention DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id) ON DELETE CASCADE,
        FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE,
        UNIQUE KEY unique_chauffeur_badge (chauffeur_id, badge_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table chauffeur_badges créée</p></div>';

    // Table rangs
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table rangs...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS rangs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        niveau INT NOT NULL UNIQUE,
        nom VARCHAR(100) NOT NULL,
        icone VARCHAR(10),
        livraisons_requises INT NOT NULL,
        couleur VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table rangs créée</p></div>';

    // Table historique
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Création table historique_stats...</p>';
    $pdo->exec("CREATE TABLE IF NOT EXISTS historique_stats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        chauffeur_id INT NOT NULL,
        livraisons_avant INT,
        livraisons_apres INT,
        kilometres_avant INT,
        kilometres_apres INT,
        date_mise_a_jour DATETIME DEFAULT CURRENT_TIMESTAMP,
        mis_a_jour_par VARCHAR(100),
        FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo '<p class="text-green-400">✅ Table historique_stats créée</p></div>';

    // Insérer les badges
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Insertion des badges...</p>';
    $pdo->exec("INSERT IGNORE INTO badges (code, nom, description, icone, condition_type, condition_valeur, couleur, ordre) VALUES
        ('rookie', 'Recrue', 'Bienvenue dans la flotte !', '🚛', 'livraisons', 0, 'from-gray-500 to-gray-700', 1),
        ('veteran', 'Vétéran', 'Plus de 100 livraisons', '⭐', 'livraisons', 100, 'from-blue-500 to-blue-700', 2),
        ('expert', 'Expert', 'Plus de 500 livraisons', '🏆', 'livraisons', 500, 'from-purple-500 to-purple-700', 3),
        ('legend', 'Légende', 'Plus de 1000 livraisons', '👑', 'livraisons', 1000, 'from-yellow-400 to-yellow-600', 4),
        ('convoy_master', 'Maître des Convois', 'Participation à 50+ convois', '🚦', 'convois', 50, 'from-green-500 to-green-700', 5),
        ('safe_driver', 'Conducteur Prudent', 'Aucun accident en 100 livraisons', '🛡️', 'accidents', 0, 'from-cyan-500 to-cyan-700', 6),
        ('night_owl', 'Hibou de Nuit', '100 livraisons nocturnes', '🌙', 'nuit', 100, 'from-indigo-500 to-indigo-700', 7),
        ('long_haul', 'Longue Distance', 'Plus de 100 000 km parcourus', '🌍', 'kilometres', 100000, 'from-teal-500 to-teal-700', 8),
        ('founding_member', 'Membre Fondateur', 'Parmi les premiers membres', '💎', 'special', 0, 'from-pink-500 to-pink-700', 9),
        ('active_member', 'Membre Actif', 'Actif depuis 6 mois', '⚡', 'anciennete', 180, 'from-orange-500 to-orange-700', 10)");
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM badges");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo '<p class="text-green-400">✅ ' . $count . ' badges insérés</p></div>';

    // Insérer les rangs
    echo '<div class="bg-slate-800 p-4 rounded-lg">';
    echo '<p class="font-bold">Insertion des rangs...</p>';
    $pdo->exec("INSERT IGNORE INTO rangs (niveau, nom, icone, livraisons_requises, couleur) VALUES
        (1, 'Apprenti', '🔰', 0, 'text-gray-400'),
        (2, 'Chauffeur', '🚚', 50, 'text-blue-400'),
        (3, 'Routier Confirmé', '🚛', 150, 'text-green-400'),
        (4, 'Expert Logistique', '⭐', 300, 'text-purple-400'),
        (5, 'Capitaine de Route', '🏆', 500, 'text-yellow-400'),
        (6, 'Légende ', '👑', 1000, 'text-red-400')");
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM rangs");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo '<p class="text-green-400">✅ ' . $count . ' rangs insérés</p></div>';

    echo '</div>';

    // Succès final
    echo '<div class="mt-8 bg-green-900/30 border-2 border-green-600 rounded-xl p-8 text-center">';
    echo '<h2 class="text-3xl font-bold text-green-400 mb-4">🎉 Installation réussie !</h2>';
    echo '<p class="text-xl mb-6">Le système TruckBook est maintenant opérationnel !</p>';
    echo '<div class="flex flex-col gap-4">';
    echo '<a href="../diagnostic-truckbook.html" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition">🔍 Vérifier avec le diagnostic</a>';
    echo '<a href="../admin-chauffeurs.html" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold transition">➕ Ajouter des chauffeurs</a>';
    echo '<a href="../equipe.html" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-bold transition">👥 Voir l\'équipe</a>';
    echo '</div>';
    echo '</div>';

} catch (PDOException $e) {
    echo '<div class="bg-red-900/30 border-2 border-red-600 rounded-xl p-6">';
    echo '<h2 class="text-2xl font-bold text-red-400 mb-4">❌ Erreur d\'installation</h2>';
    echo '<p class="text-lg mb-4">' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<div class="bg-slate-800 p-4 rounded-lg mt-4">';
    echo '<h3 class="text-xl font-bold text-yellow-400 mb-2">Solutions :</h3>';
    echo '<ol class="list-decimal list-inside space-y-2">';
    echo '<li>Vérifier que MySQL est démarré</li>';
    echo '<li>Vérifier que la base de données "transcs" existe</li>';
    echo '<li>Vérifier les permissions MySQL</li>';
    echo '<li>Essayer la méthode manuelle via phpMyAdmin</li>';
    echo '</ol>';
    echo '</div>';
    echo '</div>';
}

echo '
    </div>
</body>
</html>';
?>
