<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../controllers/pago_controller.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'crear_preferencia') {
    crearPreferenciaPago();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Ruta no encontrada"]);
}