<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// ========================================
// CONFIGURATION DES IDENTIFIANTS ADMIN
// ⚠️ CHANGEZ CES VALEURS EN PRODUCTION !
// ========================================

$ADMIN_CREDENTIALS = [
    'admin' => 'admin',  // Identifiant => Mot de passe
];

// ========================================
// TRAITEMENT DE LA REQUÊTE
// ========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        echo json_encode([
            'success' => false,
            'message' => 'Données invalides'
        ]);
        exit;
    }
    
    $username = isset($data['username']) ? trim($data['username']) : '';
    $password = isset($data['password']) ? trim($data['password']) : '';
    
    // Vérifier que les champs ne sont pas vides
    if (empty($username) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Identifiant et mot de passe requis'
        ]);
        exit;
    }
    
    // Vérifier les identifiants
    if (isset($ADMIN_CREDENTIALS[$username]) && $ADMIN_CREDENTIALS[$username] === $password) {
        // Connexion réussie
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_login_time'] = time();
        
        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'username' => $username
        ]);
    } else {
        // Identifiants incorrects
        // Attendre 1 seconde pour ralentir les attaques par force brute
        sleep(1);
        
        echo json_encode([
            'success' => false,
            'message' => 'Identifiant ou mot de passe incorrect'
        ]);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Déconnexion
    session_destroy();
    
    echo json_encode([
        'success' => true,
        'message' => 'Déconnexion réussie'
    ]);
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'check') {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        echo json_encode([
            'success' => true,
            'logged_in' => true,
            'username' => $_SESSION['admin_username']
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'logged_in' => false
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}
?>
