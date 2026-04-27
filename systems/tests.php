<?php
deleteDatabase();
makeDatabase();
$sql = "
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(1, './assets/background.png', 5, 5, 20); 
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(2, './assets/background.png', 5, 100, 32); 
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(3, './assets/background.png', 25, 55, 25); 

INSERT INTO users VALUES(1, 'boss', 'pat', 'rick', '2006-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', 'ez', 0, '2026-04-27', './assets/background.png');
INSERT INTO users VALUES(2, 'hugy', 'hugo', 'maire', '2008-11-06', '01 23 45 67 89', 'hugy@gmail.com', 'cheh', 0, '2026-04-27', './assets/background.png');
INSERT INTO users VALUES(3, 'tacos', 'antho', 'zoom', '2004-11-06', '20 40 60 80 00', 'antho@gmail.com', 'bim', 100, '2026-04-28', './assets/background.png');
";


$pdo->exec($sql);
?>
