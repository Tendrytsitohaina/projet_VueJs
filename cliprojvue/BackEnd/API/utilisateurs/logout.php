<?php
session_start();
session_destroy();
header("Access-Control-Allow-Origin: *"); // Autoriser l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET,DELETE, POST, PUT, PATCH, OPTIONS"); // Autoriser les méthodes GET, POST, PUT, PATCH et OPTIONS
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes Content-Type et Authorization
header('Access-Control-Allow-Origin: http://localhost:5173'); // frontend origin
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');


echo json_encode(['success' => true , 'message'=>'Deconnexion avec succes']);
?>