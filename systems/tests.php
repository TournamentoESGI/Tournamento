<?php
$reload = isset($_GET['reload']);
if ($reload) {
	deleteDatabase();
}

makeDatabase();

$password = password_hash("ez",PASSWORD_DEFAULT);
$sql = "
INSERT INTO users VALUES(1, 'ez', 'Ghost', 'Rex', '2000-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', '".$password."', 0, '2026-04-27', './assets/background.png', 'Admin', '1');
INSERT INTO captchas VALUES(1, './assets/captchas/Levis.png);'
";

if ($reload) {
	$pdo->exec($sql);
}
?>
