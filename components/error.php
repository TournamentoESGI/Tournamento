<?php

$errorPageMessage = "";

function displayPageError($error_message) {
	$errorPageMessage = $error_message;
	include_once("./pages/error.php");
	include_once("./components/footer.php");
	includeJsFiles();
	die();
}

?>

