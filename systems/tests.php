<?php
$reload = isset($_GET['reload']);
if ($reload) {
	deleteDatabase();
}

makeDatabase();
$password = password_hash("ez",PASSWORD_DEFAULT);
$sql = "
INSERT INTO captchas VALUES(1, 'Levi.png', '2');
INSERT INTO tournaments(author, title, status) VALUES(1, 'My tournament','ouvert');
INSERT INTO participants(user, tournament, nickname) VALUES(1, 1, 'Mergez');
INSERT INTO participants(user, tournament, nickname) VALUES(2, 1, 'Tacosinus');
";

if ($reload) {
	try {
		$pdo->exec($sql);
	}
	catch (Exception $ex) {
		sendDebug($ex);
		displayPageException($ex);
	}
}
?>
