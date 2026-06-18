<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once __DIR__ . '/../config/db_connection.php';
include_once __DIR__ . '/../controllers/usuario_controller.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? '';

if ($method === 'GET') {
    listarUsers($pdo);
} elseif ($method === 'PUT') {
    actualizarUser($pdo, $input);
} elseif ($method === 'DELETE') {
    eliminarUser($pdo, $input);
} elseif ($method === 'POST') {
    if ($action === 'register') {
        registrarUser($pdo, $input);
    } elseif ($action === 'login') {
        loginUser($pdo, $input);
    } else {
        echo json_encode(["error" => "Acción POST no válida"]);
    }
}
?>