<?php

require_once __DIR__ . '/../models/pago_model.php';

function activarSuscripcionPremium($usuarioId) {
    $resultado = actualizarPlanUsuario($usuarioId, 'premium');
    return $resultado;
}