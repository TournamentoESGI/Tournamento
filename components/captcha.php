<?php

function createCaptcha($img_path, $splits) {
	echo "<div style='width: 100%;height: auto;position: relative;'>";
	echo "<div style='background-image:url(".$img_path.");'></div>";
	/*$size = 1/$splits*100;
	for ($x=0; $x<$splits; $x++) {
		for ($y=0; $y<$splits; $y++) {
			echo "<div style='position:absolute;";
			echo "left:".($size*$x)."%;";
			echo "top:".($size*$y)."%;";
			echo "background: red;";
			echo "height:".$size."%;";
			echo "width:".$size."%;";
			echo "'>"."</div>";
		}
	}*/
	echo "</div>";
}

function generateCaptcha($pdo) {
	$stmt = $pdo->prepare("SELECT id, img_url, splits FROM captchas");
	try {
		$stmt->execute();
		$result = $stmt->fetchAll();
		$rnd = random_int(0, count($result)-1);
		$captcha = $result[$rnd];
		createCaptcha($captcha["img_url"], $captcha["splits"]);
	}
	catch(PDOException $ex) {
		echo $ex;
	}
}
?>
