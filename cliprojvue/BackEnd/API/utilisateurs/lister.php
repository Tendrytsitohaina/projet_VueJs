
<?php
header("Access-Control-Allow-Origin: *"); // Autoriser l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET,DELETE, POST, PUT, PATCH, OPTIONS"); // Autoriser les méthodes GET, POST, PUT, PATCH et OPTIONS
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes Content-Type et Authorization

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once __DIR__ . '/../../controllers/UtilisateurController.php';

    $q = isset($_GET['q']) ? $_GET['q'] : '';
    $tri = isset($_GET['tri'])? $_GET['tri'] : 'numloc';
    $controller = new UtilisateurController();

    $utilisateurs = $controller->lister($q, $tri);
    echo json_encode($utilisateurs);
    die();
    if($utilisateurs){
        echo json_encode($utilisateurs);
    }else{
        echo json_encode(['message' => 'Erreur lors de listage']);
    }
}

