<?php
$sql = "
CREATE TABLE IF NOT EXISTS users(
CURRENT_CONNECTIONS bigint,
MAX_SESSION_CONTROLLED_MEMORY bigint unsigned,
MAX_SESSION_TOTAL_MEMORY bigint unsigned,
TOTAL_CONNECTIONS bigint,
USER char(32),
creation timestamp,
date_naissance date,
email varchar(255),
id int,
nom varchar(50),
prenom varchar(50),
password varchar(50),
role varchar(10),
telephone char(10),
username varchar(15),
);
";

$pdo->exec($sql);
?>
