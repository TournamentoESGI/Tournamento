<?php

function displayPage() {
	$runner = php_sapi_name();
	$prefix = $runner!="cli"?"./":__DIR__."/../";
	if ($runner != "cli") {
		include_once($prefix."components/header.php");
	}
	include_once($prefix."pages/error.php");
	if ($runner != "cli") {
		include_once($prefix."components/footer.php");
	}
}

function autoErrorHandler($errno, $errstr, $errfile, $errline) {
	echo "</main>";
	global $errorPageMessage;
	$errorPageMessage = "Auto";
	$errorPageMessage = $errorPageMessage.";".$errno;
	$errorPageMessage = $errorPageMessage.";".$errstr;
	$errorPageMessage = $errorPageMessage.";".$errfile;
	$errorPageMessage = $errorPageMessage.";".$errline;
	displayPage();
	die();
}
set_error_handler("autoErrorHandler");

function displayPageNotFound() {
	displayPageError("Page not found 404", "404");
}

function displayPageError($error_message, $mode="Manuel") {
	echo "</main>";
	global $errorPageMessage;
	$errorPageMessage = $mode.";".$error_message;
	displayPage();
	die();
}
function displayPageException(Exception $ex) {
	echo "</main>";
	global $errorPageMessage;
	$errorPageMessage = "Auto";
	$errorPageMessage = $errorPageMessage.";".$ex->getCode();
	$errorPageMessage = $errorPageMessage.";".$ex->getMessage();
	$errorPageMessage = $errorPageMessage.";".$ex->getFile();
	$errorPageMessage = $errorPageMessage.";".$ex->getLine();
	displayPage();
	die();
}
?>

