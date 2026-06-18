<?php

require_once __DIR__ . '/../services/pago_service.php';

function crearPreferenciaPago() {
    $envPath = __DIR__ . '/../.env';

    if (file_exists($envPath)) {
        $env = parse_ini_file($envPath);
        $mpToken = $env['MP_ACCESS_TOKEN'] ?? null;
        $baseUrl = $env['BACKEND_URL'] ?? 'http://localhost:8000';
    } else {
        $mpToken = getenv('MP_ACCESS_TOKEN');
        $baseUrl = getenv('BACKEND_URL');
    };

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['usuario_id'])) {
        http_response_code(400);
        echo json_encode(["error" => "El usuario_id es requerido"]);
        exit;
    }

    $usuarioId = $input['usuario_id'];
    $titulo = $input['titulo'] ?? 'Plan Premium - Mis Notas';
    $precio = $input['precio'] ?? 99.00;

    $preferenceData = [
        "items" => [
            [
                "title" => $titulo,
                "quantity" => 1,
                "unit_price" => (float)$precio,
                "currency_id" => "MXN"
            ]
        ],
        "external_reference" => (string)$usuarioId,

        "notification_url" => $baseUrl . "/routes/webhook_pago.php",
        
        "back_urls" => [
            "success" => "http://localhost:5173",
            "failure" => "http://localhost:5173",
            "pending" => "http://localhost:5173"
        ],
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.mercadopago.com/checkout/preferences",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($preferenceData),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $mpToken,
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    header('Content-Type: application/json');
    if ($statusCode === 201 || $statusCode === 200) {
        echo $response;
    } else {
        http_response_code($statusCode);
        echo json_encode(["error" => "Error al conectar con Mercado Pago", "details" => json_decode($response, true)]);
    }
}