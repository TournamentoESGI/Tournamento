<?php
function createCaptcha($img_path, $pos_x, $pos_y, $scale) {
	echo "<div class='captcha' ";
	echo "data-img='".$img_path."'";
	echo "data-pos='".$pos_x.";".$pos_y."'";
	echo "data-scale='".$scale."'";
	echo "></div>";
	include_js('./scripts/captcha.js');
}

function generateCaptcha($pdo) {
	echo "<div class='captcha-section'>";
	$stmt = $pdo->prepare("SELECT id, img_url, posX, posY, scale FROM captchas");
	try {
		$stmt->execute();
		$result = $stmt->fetchAll();
		$rnd = random_int(0, count($result)-1);
		$captcha = $result[$rnd];

		echo "<p>Deplacer le puzzle dans l'emplacement vide</p>";
		createCaptcha($captcha["img_url"], $captcha["posX"], $captcha["posY"], $captcha["scale"]);
		echo "<button>Valider</button>";
	}
	catch(PDOException) {
		echo "<p>Problème de connection à la db</p>";
	}
	catch(Exception) {
		echo "<p>Captcha indisponible</p>";
	}
	echo "</div>";
}

?>
