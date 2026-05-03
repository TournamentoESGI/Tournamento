<?php

enum CaptchaMode
{
	case Make;
	case Solve;
};

function createCaptcha($img_path, $splits, $gaps, CaptchaMode $mode) {
	echo "<div class='captcha' ";
	echo 'data-splits="'.$splits.'"';
	echo 'data-img="'.DIR_CAPTCHAS.$img_path.'"';
	echo 'data-gap="'.$gaps.'"';
	switch ($mode) {
		case CaptchaMode::Make:
			echo 'data-mode="make"';
		case CaptchaMode::Solve:
			echo 'data-mode="solve"';
	}
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
		createCaptcha($captcha["img_url"], $captcha["splits"], 8, CaptchaMode::Solve);
	}
	catch(PDOException $ex) {
		echo $ex;
	}
}

function isCaptchaValid($data) {
	$values = explode(" ", $data);
	$rowLength = sqrt(count($values));
	$valid = true;
	for ($i=0; $i<count($values);$i++) {
		$x = explode(";",$values[$i])[0];
		$y = explode(";",$values[$i])[1];
		if ($x != $i%$rowLength) {
			$valid = false;
		}
		if ($y != floor($i/$rowLength)) {
			$valid = false;
		}
	}
	return $valid;
}
?>
