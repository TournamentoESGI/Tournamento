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
}
else {
	$sql = "INSERT INTO users (id, username, first_name, last_name, date_of_birth, phone, email_address, password, role, current_balance, is_verified)
	VALUES (1, 'admin', 'admin', 'admin', '1969-11-06', '12 34 56 78 90', 'p.nikiel@myskolae.fr', '.$password.', 'Admin', 10000, 1 );"
	testSQL($sql);
}

?>
