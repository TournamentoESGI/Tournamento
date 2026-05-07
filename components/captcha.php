<?php

enum CaptchaMode
{
	case Make;
	case Solve;
};

function createCaptcha($img_path, $splits, $gaps, CaptchaMode $mode) {
	$img_path = DIR_CAPTCHAS.$img_path;
	echo "<div class='captcha' ";
	if (!file_exists($img_path)) {
		echo ">";
		switch ($mode) {
			case CaptchaMode::Make:
				echo "<p>Image $img_path not found</p>";
				break;
			case CaptchaMode::Solve:
				echo "<p>Image not found</p>";
				break;
		}
		echo "</div>";
		return;
	}
	echo 'data-splits="'.$splits.'"';
		
	echo 'data-img="'.$img_path.'"';
	echo 'data-gap="'.$gaps.'"';
	switch ($mode) {
		case CaptchaMode::Make:
			echo 'data-mode="make"';
			break;
		case CaptchaMode::Solve:
			echo 'data-mode="solve"';
			break;
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
	$rowLength = floor(sqrt(count($values)));
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
