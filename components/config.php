<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $_ENV['DB_HOST'], $_ENV['DB_BASE']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
} catch (Exception $ex) {
    error_log($ex->getMessage()); 
    http_response_code(500);
    die('Erreur de connexion à la base de données');
}