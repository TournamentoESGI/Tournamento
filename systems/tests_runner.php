<?php

$runner = php_sapi_name();
$prefix = $runner!="cli"?"./":__DIR__."/../";

$password = password_hash("ez", PASSWORD_DEFAULT);

include_once($prefix."components/utilities.php");
include_once($prefix."components/error.php");
include_once($prefix."systems/config.php");
include_once($prefix."components/data.php");

deleteDatabase();
makeDatabase();

if ($runner != "cli") {
	include_once("./systems/tests.php");
	if (isset($_GET['url'])) {
		echo "<script> window.location.replace('".$_GET['url']."')</script>";
	}
}
else {
	include_once("./systems/tests_prod.php");
}

?>
