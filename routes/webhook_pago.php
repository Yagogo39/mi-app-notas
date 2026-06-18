<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../services/pago_service.php';

$type = $_GET['type'] ?? null;
$paymentId = $_GET['data_id'] ?? $_GET['data.id'] ?? null;

$input = json_decode(file_get_contents('php://input'), true);
if (!$type && isset($input['type'])) {
    $type = $input['type'];
    $paymentId = $input['data']['id'] ?? null;
}

if ($type === 'payment' && $paymentId) {

    $envPath = __DIR__ . '/../.env';
    if (file_exists($envPath)) {
        $env = parse_ini_file($envPath);
        $mpToken = $env['MP_ACCESS_TOKEN'] ?? null;
    } else {
        $mpToken = getenv('MP_ACCESS_TOKEN');
    }
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.mercadopago.com/v1/payments/" . $paymentId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $mpToken
        ]
    ]);
    
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode === 200) {
        $paymentData = json_decode($response, true);
        
        $status = $paymentData['status'] ?? '';
        $usuarioId = $paymentData['external_reference'] ?? null;

        if ($status === 'approved' && $usuarioId) {
            $exito = activarSuscripcionPremium($usuarioId);
            
            if ($exito) {
                http_response_code(200);
                echo json_encode(["message" => "Webhook procesado. Usuario $usuarioId ahora es Premium."]);
                exit;
            }
        }
    }
}

http_response_code(200);
echo json_encode(["message" => "Notificación recibida de forma segura"]);