<?php
/**
 * Script de nettoyage automatique des convois expirés
 * 
 * Ce script peut être exécuté via un cron job pour nettoyer automatiquement
 * les convois expirés (30 minutes après leur date/heure)
 * 
 * Configuration cron (toutes les 5 minutes) :
 * */5 * * * * /usr/bin/php /chemin/vers/votre/site/cron-cleanup.php
 * 
 * Ou via une tâche planifiée Windows :
 * Toutes les 5 minutes : php.exe "C:\wamp64\www\SiteETS\\cron\cron-cleanup.php"
 */

require_once __DIR__ . '/../config.php';

$pdo = getDBConnection();
if (!$pdo) {
    error_log("❌ Erreur de connexion à la base de données pour le nettoyage");
    exit(1);
}

try {
    // Supprimer les convois dont la date + heure + 30 minutes est passée
    $stmt = $pdo->prepare("
        DELETE FROM convois 
        WHERE DATE_ADD(CONCAT(date, ' ', heure), INTERVAL 30 MINUTE) < NOW()
    ");
    
    $stmt->execute();
    $deletedCount = $stmt->rowCount();
    
    // Les photos seront supprimées automatiquement grâce à ON DELETE CASCADE
    
    if ($deletedCount > 0) {
        error_log("🧹 Nettoyage automatique: $deletedCount convoi(s) expiré(s) supprimé(s)");
        echo "✅ $deletedCount convoi(s) expiré(s) supprimé(s)\n";
    } else {
        echo "ℹ️ Aucun convoi expiré à supprimer\n";
    }
    
    exit(0);
    
} catch (PDOException $e) {
    error_log("❌ Erreur lors du nettoyage automatique: " . $e->getMessage());
    exit(1);
}

?>
