<?php
include_once __DIR__ . '/../models/notas_model.php';

function obtenerApuntesUsuario($pdo, $usuario_id) {
    if (empty($usuario_id)) return false;
    return getApuntesByUsuario($pdo, $usuario_id);
}

function guardarApunte($pdo, $input) {
    if (empty($input['usuario_id']) || empty($input['titulo']) || empty($input['contenido'])) {
        return false;
    }
    return createApunte($pdo, $input);
}

function modificarApunte($pdo, $input) {
    if (empty($input['id']) || empty($input['usuario_id']) || empty($input['titulo']) || empty($input['contenido'])) {
        return false;
    }
    return updateApunte($pdo, $input);
}

function eliminarApunte($pdo, $input) {
    if (empty($input['id']) || empty($input['usuario_id'])) {
        return false;
    }
    return deleteApunte($pdo, $input);
}
?>