<?php
//deleteDatabase();
makeDatabase();
$sql = "
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(1, './assets/background.png', 5, 5, 20); 
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(2, './assets/background.png', 5, 100, 32); 
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(3, './assets/background.png', 25, 55, 25); 
";
//$pdo->exec($sql);
?>
