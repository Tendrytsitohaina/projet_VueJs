<?php
session_start();
header("Access-Control-Allow-Origin: *"); // Autoriser l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET,DELETE, POST, PUT, PATCH, OPTIONS"); // Autoriser les méthodes GET, POST, PUT, PATCH et OPTIONS
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes Content-Type et Authorization
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../../config/database.php';
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

$pdo = Database::connect();

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    if (password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['codeCli'];
        echo json_encode(['success' => true, 'message'=> $_SESSION['user_id']]);
    }else {
        echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect.']);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
}
?>