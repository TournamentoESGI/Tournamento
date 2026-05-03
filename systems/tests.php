<?php
$reload=count($_GET)==0;

if ($reload) {
	deleteDatabase();
}

makeDatabase();
$sql = "
INSERT INTO captchas VALUES(1, 'Levi.png', 4); 
INSERT INTO captchas VALUES(2, 'background.png', 3);

#INSERT INTO users VALUES(1, 'boss', 'pat', 'rick', '2006-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', 'ez', 0, '2026-04-27', './assets/background.png');
#INSERT INTO users VALUES(2, 'hugy', 'hugo', 'maire', '2008-11-06', '01 23 45 67 89', 'hugy@gmail.com', 'cheh', 0, '2026-04-27', './assets/background.png');
#INSERT INTO users VALUES(3, 'tacos', 'antho', 'zoom', '2004-11-06', '20 40 60 80 00', 'antho@gmail.com', 'bim', 100, '2026-04-28', './assets/background.png');
";

if ($reload) {
	$pdo->exec($sql);
}
?>
