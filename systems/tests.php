<?php
deleteDatabase();
makeDatabase();
$sql = "
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(1, './assets/background.png', 5, 5, 32); 
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(2, './assets/background.png', 5, 100, 32); 
";
$pdo->exec($sql);
?>
