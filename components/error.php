<?php
$errorPageMessage = "";

function displayPageError($error_message) {
	global $errorPageMessage;
	include_once("./components/header.php");
	$errorPageMessage = $error_message;
	include_once("./pages/error.php");
	include_once("./components/footer.php");
	die();
}

?>

