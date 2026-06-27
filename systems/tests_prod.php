<?php
$prefix = $runner!="cli" ? "./" : __DIR__."/../";
include_once($prefix."components/data.php");

$password_sanane = password_hash("Sanane01234.!", PASSWORD_DEFAULT);
$password_admin = password_hash("AdminSanane01234.!", PASSWORD_DEFAULT);

$sql = "
INSERT INTO users (
    id, username, first_name, last_name, date_of_birth,
    phone, email_address, password, role, current_balance, is_verified
) VALUES (
    1,
    'Le patron',
    'Frédéric',
    'Sanane',
    '1969-11-06',
    '12 34 56 78 90',
    'fsananes@esgi.fr',
    '".$password_sanane."',
    'Admin',
    10000,
    1
);

INSERT INTO users (
    id, username, first_name, last_name, date_of_birth,
    phone, email_address, password, role, current_balance, is_verified
) VALUES (
    1,
    'Le sinistre',
    'Debian',
    'Linux',
    '1969-11-06',
    '01 23 45 67 89',
    'fsananes@esgi.fr',
    '".$password_admin."',
    'Admin',
    10000,
    1
);
";

testSQL($sql);
?>
