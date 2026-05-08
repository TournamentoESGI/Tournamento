<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$env = parse_ini_file('.env');

include_once('./components/security.php');

try {
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $env['DB_HOST'], $env['DB_BASE']);

	$options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    
	$pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASSWORD'], $options);
    
	include_once('./systems/setup.php');
	include_once('./systems/tests.php');
	makeDatabase();

} catch (Exception $ex) {
    displayPageError($ex->getMessage());
}
?>
