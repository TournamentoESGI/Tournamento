<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set("Europe/Paris");

$runner = php_sapi_name();
$prefix = $runner!="cli"?"":__DIR__."/../";
$env = parse_ini_file($prefix.'.env');

include_once('./components/security.php');

include_once('./components/mail.php');

try {
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $env['DB_HOST'], $env['DB_BASE']);

	$options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    
	$pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASSWORD'], $options);
    
	include_once('./components/data.php');
	if (file_exists('./systems/setup.php')) {
		include_once('./systems/setup.php');
	}
	if (isset($_GET['reload'])) {
		include_once('./systems/tests_runner.php');
	}
	makeDatabase();

} catch (Exception $ex) {
    displayPageError($ex->getMessage());
}

if (isset($_SESSION['id'])) {
    try {
        $stmt = $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE id = ?");
        $stmt->execute([$_SESSION['id']]);

        $stmt = $pdo->prepare("SELECT force_logout FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['id']]);
        $userStatus = $stmt->fetch();

        if ($userStatus && $userStatus['force_logout'] == 1) {
            $stmt = $pdo->prepare("UPDATE users SET force_logout = 0 WHERE id = ?");
            $stmt->execute([$_SESSION['id']]);

            session_destroy();
            
            header("Location: ?page=login");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour de l'activité : " . $e->getMessage());
    }
}

?>
