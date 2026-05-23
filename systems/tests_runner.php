<?php

$runner = php_sapi_name();
$prefix = $runner!="cli"?"./":__DIR__."/../";

include_once($prefix."components/utilities.php");
include_once($prefix."components/error.php");
include_once($prefix."systems/config.php");
include_once($prefix."components/data.php");

deleteDatabase();
makeDatabase();

if ($runner != "cli") {
	include_once("./systems/tests.php");
}

?>
