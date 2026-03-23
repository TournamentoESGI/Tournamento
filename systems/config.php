<?php
$rootDir = __DIR__ . '/../';

include_once($rootDir."components/error.php");
include_once($rootDir . "components/error.php");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$env = parse_ini_file($rootDir . '.env');

$pdo = NULL;

try {
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $env['DB_HOST'], $env['DB_BASE']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    
    $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASSWORD'], $options);
    
    include_once(__DIR__ . '/setup.php');

} catch (Exception $ex) {
    error_log($ex->getMessage()); 
    http_response_code(500);
    //displayPageError($ex->getMessage());
}
?>
