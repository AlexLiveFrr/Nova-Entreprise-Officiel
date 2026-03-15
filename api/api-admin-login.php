<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer la requête preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config.php';

initDatabase();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username']) || empty(trim($input['username']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Identifiant requis']);
    exit;
}

if (!isset($input['password']) || empty(trim($input['password']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Mot de passe requis']);
    exit;
}

$username = trim($input['username']);
$password = trim($input['password']);

$pdo = getDBConnection();
if (!$pdo) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données']);
    exit;
}

try {
    // Chercher l'admin par username
    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password_hash'])) {
        // Générer un token de session
        $token = bin2hex(random_bytes(32));
        
        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie',
            'username' => $admin['username'],
            'token' => $token
        ]);
        exit;
    }
    
    // Identifiant ou mot de passe incorrect
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Identifiant ou mot de passe incorrect']);
    
} catch (PDOException $e) {
    error_log("Erreur admin login: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
}
?>
