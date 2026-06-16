<?php

function getUsersbyEmail($pdo, $email){
    $query = ("SELECT * FROM usuarios WHERE email = :email");
    $stmt = $pdo->prepare($query);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function createUser($pdo, $input){
    $query = ("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':nombre' => $input['nombre'],
        ':email' => $input['email'],
        ':password' => $input['password']
    ]);
    echo json_encode(['message' => 'Usuario creado']);
}
function updateUser($pdo, $input){
    $query = ("UPDATE usuarios SET nombre = :nombre, email = :email, password = :password WHERE id = :id");
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id' => $input['id'],
        ':nombre' => $input['nombre'],
        ':email' => $input['email'],
        ':password' => $input['password']
    ]);
    
    echo json_encode(['message' => 'Usuario actualizado']);
}

function deleteUser($pdo, $input){
    $query = ("DELETE FROM usuarios WHERE id = :id");
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $input['id']]);
    echo json_encode(['message' => 'Usuario eliminado']);
}
?>
