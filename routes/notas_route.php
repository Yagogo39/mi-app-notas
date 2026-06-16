<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once __DIR__ . '/../config/db_connection.php';
include_once __DIR__ . '/../controllers/notas_controller.php';

$headers = getallheaders();
$usuario_id = false;

if (isset($headers['Authorization'])) {
    $usuario_id = base64_decode(str_replace('Bearer ', '', $headers['Authorization']));
}

if (!$usuario_id) {
    http_response_code(401);
    exit(json_encode(['message' => 'Falta el Token']));
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'GET') {
    listarApuntes($pdo, $usuario_id);
} elseif ($method === 'POST') {
    $input['usuario_id'] = $usuario_id;
    registrarApunte($pdo, $input);
} elseif ($method === 'PUT') {
    $input['usuario_id'] = $usuario_id;
    actualizarApunte($pdo, $input);
} elseif ($method === 'DELETE') {
    $input['usuario_id'] = $usuario_id;
    eliminarApunte($pdo, $input);
}
?>