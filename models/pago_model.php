<?php
require_once __DIR__ . '/../config/db_connection.php';

function actualizarPlanUsuario($usuarioId, $nuevoPlan) {
    global $pdo;

    try {
        $sql = "UPDATE usuarios SET plan = :plan WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':plan' => $nuevoPlan,
            ':id' => $usuarioId
        ]);

        return true;
    } catch (PDOException $e) {
        error_log("Error en actualizarPlanUsuario: " . $e->getMessage());
        return false;
    }
}