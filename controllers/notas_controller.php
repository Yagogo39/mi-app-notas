<?php
include_once __DIR__ . '/../services/notas_service.php';

function listarApuntes($pdo, $usuario_id) {
    $apuntes = obtenerApuntesUsuario($pdo, $usuario_id);
    if ($apuntes === false) {
        http_response_code(400);
        echo json_encode(['message' => 'Falta el ID del usuario']);
    } else {
        http_response_code(200);
        echo json_encode($apuntes);
    }
}

function registrarApunte($pdo, $input) {
    $response = guardarApunte($pdo, $input);
    if ($response === false) {
        http_response_code(400);
        echo json_encode(['message' => 'Los campos usuario_id, titulo y contenido son obligatorios']);
    } else {
        http_response_code(201);
        echo json_encode(['message' => 'Apunte creado exitosamente']);
    }
}

function actualizarApunte($pdo, $input) {
    $response = modificarApunte($pdo, $input);
    if ($response === false) {
        http_response_code(400);
        echo json_encode(['message' => 'Error al actualizar el apunte, verifica los campos']);
    } else {
        http_response_code(200);
        echo json_encode(['message' => 'Apunte actualizado exitosamente']);
    }
}

function eliminarApunteXD($pdo, $input) {
    $response = eliminarApunte($pdo, $input);
    if ($response === false) {
        http_response_code(400);
        echo json_encode(['message' => 'Error al eliminar el apunte']);
    } else {
        http_response_code(200);
        echo json_encode(['message' => 'Apunte eliminado exitosamente']);
    }
}
?>