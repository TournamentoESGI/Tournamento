<?php
include_once("./components/utilities.php");
include_once("./components/error.php");
include_once("./systems/config.php");
include_once("./components/data.php");

deleteDatabase();
makeDatabase();

include_once("./systems/tests.php");

?>
