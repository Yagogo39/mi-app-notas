<?php

$env = __DIR__ . '/../.env';

if (file_exists($env)) {
    $env = parse_ini_file($env);
    $host = $env['host'] ?? null;
    $port = $env['port'] ?? null;
    $dbname = $env['database'] ?? null;
    $user = $env['user'] ?? null;
    $password = $env['password'] ?? null;
} else {
    $host = getenv('host');
    $port = getenv('port');
    $dbname = getenv('database');
    $user = getenv('user');
    $password = getenv('password');
}

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión a la base de datos", "details" => $e->getMessage()]);
    exit;
}