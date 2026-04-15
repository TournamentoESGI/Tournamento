<?php
deleteDatabase();
makeDatabase();
$sql = "
INSERT INTO captchas(id, img_url, posX, posY, scale) VALUES(1, './assets/background.png', 5, 10, 5); 
";
$pdo->exec($sql);
?>
