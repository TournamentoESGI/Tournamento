<?php
function createGraphColumn($value, $maxValue, $count) {
	echo "<div class='graph-column' style='height:";
	echo $value/$maxValue*100;
	echo "%; width:";
	echo 1/$count*100;
	echo "%'></div>";
}

function createGraph($sql,$pdo) {
	if (!$pdo) {
		return;
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();
	if (!$result) {
		echo "Invalid Syntax or wrong table";
		echo "</div>";
		return;
	}

	$col_count = count($result);
	$max_value = (int)$result[0][0];

	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)$result[$i][0];

		if ($value > $max_value) {
			$max_value = $value;
		}
	}

	echo '<div class="graph">';
	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)$result[$i][0];
		createGraphColumn($value, $max_value, $col_count);
	}
	echo "</div>";
}

function createCaptcha($img_path, $nb_piece) {
	echo "<div id='captcha' ";
	echo "data-img='".$img_path."'";
	echo "data-splits='".$nb_piece."'";
	echo "></div>";
	echo "<script src='./scripts/captcha.js'></script>";
}

function generateCaptcha($pdo) {
	$stmt = $pdo->prepare("SELECT id, img_url, splits, valid FROM captchas");
	$stmt->execute();
	$result = $stmt->fetchAll();
	$rnd = random_int(0, count($result)-1);
	$captcha_info = $result[$rnd];
	$captcha_img = $captcha_info["img_url"];
	$captcha_objet = $captcha_info["id"];
	$captcha_splits = $captcha_info["splits"];
	$captcha_valids = $captcha_info["valid"];

	echo "<div class='captcha-section'>";
	echo "<p>Cochez les cases ou se trouve un ".$captcha_objet."</p>";
	createCaptcha($captcha_img,$captcha_splits);
	echo "<button>Envoyer les reponses</button>";
	echo "</div>";
}

?>
