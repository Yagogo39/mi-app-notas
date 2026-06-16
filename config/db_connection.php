<?php

$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env['host'];
$port = $env['port'];
$database = $env['database'];
$user = $env['user'];
$password = $env['password'];

try{
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>