<?php
$reload = isset($_GET['reload']);
if ($reload) {
	deleteDatabase();
}

makeDatabase();
$password = password_hash("ez",PASSWORD_DEFAULT);
$sql = "
INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('ez', 'Ghost', 'Rex', '2000-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', '".$password."', 'Admin');
INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('tacos', 'Caporal', 'Zzz', '2000-11-06', '34 56 78 90 12', 'anthony@gmail.com', '".$password."', 'Membre');

INSERT INTO tournaments(author, title, status)
VALUES(1, 'My tournament','ouvert');
INSERT INTO participants(user, tournament, nickname)
VALUES(1, 1, 'Mergez');
INSERT INTO participants(user, tournament, nickname)
VALUES(2, 1, 'Tacosinus');
>>>>>>> 9aa80bd (Adding tournament user protection)
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
