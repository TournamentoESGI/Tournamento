<?php

enum CaptchaMode
{
	case Create;
	case Check;
}

function createCaptcha($img_path, $pos_x, $pos_y, $scale,CaptchaMode $mode) {
	if (!is_numeric($pos_x) || !is_numeric($pos_y)) {
		echo "Invalid position format";
	}
	else {
		echo "<div class='container'>";
		echo "<div class='captcha' ";
		echo "data-img='".$img_path."'";
		echo "data-pos='".$pos_x.";".$pos_y."'";
		echo "data-scale='".$scale."'";
		echo "data-mode='";
		switch ($mode) {
			case CaptchaMode::Check:
				echo "check";
			case CaptchaMode::Create:
				echo "create";
		}
		echo "'>";
		echo "</div>";
		echo "</div>";
		include_js('./scripts/captcha.js');
	}
}


function generateCaptcha($pdo) {
	echo "<p>Deplacer le puzzle dans l'emplacement vide</p>";
	echo "<div class='captcha-section'>";
	$stmt = $pdo->prepare("SELECT id, img_url, posX, posY, scale FROM captchas");
	try {
		$stmt->execute();
		$result = $stmt->fetchAll();
		$rnd = random_int(0, count($result)-1);
		$captcha = $result[$rnd];

		createCaptcha($captcha["img_url"], $captcha["posX"], $captcha["posY"], $captcha["scale"], CaptchaMode::Check);
	}
	catch(PDOException) {
		echo "<p>Problème de connection à la db</p>";
	}
	catch(Exception) {
		echo "<p>Captcha indisponible</p>";
	}
	echo "</div>";
}

function configCaptchaList($pdo) {
	$stmt = $pdo->prepare("SELECT id, img_url, posX, posY, scale FROM captchas");
	try {
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $captcha) {
			echo "<div class='captcha-section'>";
			createCaptcha($captcha["img_url"], $captcha["posX"], $captcha["posY"], $captcha["scale"], CaptchaMode::Create);
			echo "</div>";
		}
	}
	catch(Exception) {
		echo "<p>Captcha indisponible</p>";
	}
}

function isCaptchaValid($pdo, $captcha_id, $pos) {
	$stmt = $pdo->prepare("SELECT posX FROM captchas WHERE id = ".$captcha_id.";");
	try {
		$stmt->execute();
		$result = $stmt->fetchAll();
		$target = $result[0]["posX"];
		$threshold = 2;
		if (abs($target-$pos)<$threshold) {
			return true;
		}
		return false;
	}
	catch(Exception) {
		return false;
	}
}

?>
