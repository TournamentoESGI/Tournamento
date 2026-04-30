<?php

function createCaptcha($img_path, $splits) {
	echo "<div class='captcha' ";
	echo 'data-splits="'.$splits.'"';
	echo 'data-img="'.$img_path.'"';
	echo "></div>";
	include_js("./scripts/captcha.js");
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
