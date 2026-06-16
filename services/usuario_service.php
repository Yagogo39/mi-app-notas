<?php

include_once __DIR__ . '/../models/usuarios_model.php';

function obtenerTodosLosUsuarios($pdo) {
    return getUsers($pdo);
}

function registrarUsuario($pdo, $input){
    if(empty($input['nombre']) || empty($input['email']) || empty($input['password'])){
        return false;
    }

    createUser($pdo, $input);
    return true;
}

function loginUsuario($pdo, $input){
    if (empty($input['email']) || empty($input['password'])) {
        return false;
    
    }

    $user = getUsersbyEmail($pdo, $input['email']);
    if ($user && $user['password'] === $input['password']) {
        return $user;
    }
    return false;
}

function actualizarUsuario($pdo, $input){
    if(empty($input['id']) || empty($input['nombre']) || empty($input['email']) || empty($input['password'])){
        return false;
    }

    updateUser($pdo, $input);
    return true;
}

function eliminarUsuario($pdo, $input){
    if(empty($input['id'])){
        return false;
    }

    deleteUser($pdo, $input);
    return true;
}

?>