<?php
$prefix = $runner!="cli" ? "./" : __DIR__."/../";
include_once($prefix."components/data.php");

$password = password_hash("ez", PASSWORD_DEFAULT);

$sql = "
INSERT INTO users (
    id, username, first_name, last_name, date_of_birth,
    phone, email_address, password, role, current_balance, is_verified
) VALUES (
    1,
    'admin',
    'admin',
    'admin',
    '1969-11-06',
    '12 34 56 78 90',
    'p.nikiel@myskolae.fr',
    '".$password."',
    'Admin',
    10000,
    1
);
";

testSQL($sql);
?>
