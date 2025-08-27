<?php
header("Access-Control-Allow-Origin: *"); // Autoriser l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET,DELETE, POST, PUT, PATCH, OPTIONS"); // Autoriser les méthodes GET, POST, PUT, PATCH et OPTIONS
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes Content-Type et Authorization

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../../controllers/UtilisateurController.php';

$data = json_decode(file_get_contents("php://input"), true);
$controller = new UtilisateurController();

if ($controller->modifier($data)) {
    echo json_encode(['message' => 'Modification du location N` '. $data['numloc'].' réussie']);
} else {
    echo json_encode(['message' => 'Erreur lors de la modification']);
}
?>