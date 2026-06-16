<?php

include_once __DIR__ . '/../services/usuario_service.php';


function listarUsers($pdo) {
    $usuarios = obtenerTodosLosUsuarios($pdo);
    echo json_encode($usuarios);
}

function registrarUser($pdo, $input){
    $response = registrarUsuario($pdo, $input);
    
    if($response === false){
        http_response_code(400);
        echo json_encode(['message' => 'Error al registrar el usuario']);
    } else {
        http_response_code(201);
    }
}

function loginUser($pdo, $input){
    $response = loginUsuario($pdo, $input);
    
    if($response === false){
        http_response_code(401);
        echo json_encode(['message' => 'Error al iniciar sesión']);
        return;
    } else {
        $token = base64_encode($response['id']);
        http_response_code(200);
        echo json_encode([
            'message' => '¡Login exitoso!',
            'token' => $token
        ]);
        return;
    }
}

function actualizarUser($pdo, $input){
    $response = actualizarUsuario($pdo, $input);
    
    if($response === false){
        http_response_code(400);
        echo json_encode(['message' => 'Error al actualizar el usuario']);
    } else {
        http_response_code(200);
        echo json_encode($response);
    }
}

function eliminarUser($pdo, $input){
    $response = eliminarUsuario($pdo, $input);
    
    if($response === false){
        http_response_code(400);
        echo json_encode(['message' => 'Error al eliminar el usuario']);
    } else {
        http_response_code(200);
        echo json_encode($response);
    }
}

?>