<?php
deleteDatabase();
makeDatabase();
$sql = "
INSERT INTO users(id_users, username, first_name, last_name, date_of_birth, phone, email_address, password, role) VALUES(1, 'boss', 'pat', 'rick', '2006-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', 'ez', 'Admin');
";
$pdo->exec($sql);
?>