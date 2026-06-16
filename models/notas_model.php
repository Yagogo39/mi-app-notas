<?php

function getApuntesByUsuario($pdo, $usuario_id) {
    $query = "SELECT * FROM apuntes WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':usuario_id' => $usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createApunte($pdo, $input) {
    $query = "INSERT INTO apuntes (usuario_id, titulo, contenido, categoria, urgencia) 
              VALUES (:usuario_id, :titulo, :contenido, :categoria, :urgencia)";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        ':usuario_id' => $input['usuario_id'],
        ':titulo'     => $input['titulo'],
        ':contenido'  => $input['contenido'],
        ':categoria'  => $input['categoria'],
        ':urgencia'   => $input['urgencia']
    ]);
}

function updateApunte($pdo, $input) {
    $query = "UPDATE apuntes 
              SET titulo = :titulo, contenido = :contenido, categoria = :categoria, urgencia = :urgencia 
              WHERE id = :id AND usuario_id = :usuario_id";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        ':id'         => $input['id'],
        ':usuario_id' => $input['usuario_id'],
        ':titulo'     => $input['titulo'],
        ':contenido'  => $input['contenido'],
        ':categoria'  => $input['categoria'],
        ':urgencia'   => $input['urgencia']
    ]);
}

function deleteApunte($pdo, $input) {
    $query = "DELETE FROM apuntes WHERE id = :id AND usuario_id = :usuario_id";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        ':id'         => $input['id'],
        ':usuario_id' => $input['usuario_id']
    ]);
}
?>