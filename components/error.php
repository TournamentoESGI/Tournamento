<?php

function autoErrorHandler($errno, $errstr, $errfile, $errline) {
	echo "</main>";
	global $errorPageMessage;
	$errorPageMessage = "Auto";
	$errorPageMessage = $errorPageMessage.";".$errno;
	$errorPageMessage = $errorPageMessage.";".$errstr;
	$errorPageMessage = $errorPageMessage.";".$errfile;
	$errorPageMessage = $errorPageMessage.";".$errline;
	include_once("./components/header.php");
	include_once("./pages/error.php");
	include_once("./components/footer.php");
	die();
}

set_error_handler("autoErrorHandler");

function displayPageError($error_message) {
	global $errorPageMessage;
	include_once("./components/header.php");
	$errorPageMessage = "Manuel;".$error_message;
	include_once("./pages/error.php");
	include_once("./components/footer.php");
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
	include_once("./components/header.php");
	include_once("./pages/error.php");
	include_once("./components/footer.php");
	die();
}

?>

