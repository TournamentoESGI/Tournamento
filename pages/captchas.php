<h1>My captchas</h1>

<div style="padding: 16px; display: flex; flex-direction: column">
	<h1>Add captcha</h1>
	<form action="index.php?page=captchas" method="post" style="display: flex; flex-direction: column; gap: 8px;" enctype="multipart/form-data">
		<input type="number" min="2" style="width: fit-content" name="splits"/>
		<input type="file" name="image"/>
		<input type="submit" name="submit_image" value="Create Captcha">
	</form>
</div>

<?php
if (isset($_POST['submit_image'])) {
	if (count($_FILES)>0 && isset($_POST['splits']) && is_numeric($_POST['splits'])) {
		$file_name = $_FILES["image"]["name"];
		$file_size = $_FILES["image"]['size'];
		$captcha_path = DIR_CAPTCHAS.basename($file_name);

		$splits = $_POST['splits'];

		if ($file_size >= 0) {
			move_uploaded_file($_FILES["image"]["tmp_name"], $captcha_path);
			$sql = "INSERT INTO captchas (img_url, splits) VALUES ('$file_name', '$splits');";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			sendLog("Created captcha");
		}
		else {
			echo "No image !";
		}
	}
}

if (isset($_POST['submit_delete'])) {
	$captcha_id = $_POST['id'];
	try {
		$sql = "SELECT img_url FROM captchas WHERE id = ".$captcha_id.";";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if (count($result) == 1) {
			$captcha_path = DIR_CAPTCHAS.$result[0]["img_url"];
			
			if (file_exists($captcha_path)) {
				unlink($captcha_path);
			}
			$sql = "DELETE FROM captchas WHERE id=".$captcha_id.";";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();

			sendLog("Deleted captcha");
		}
	}
	catch(PDOException $ex) {
		displayPageError($ex->getMessage());
	}
}

include_once("./components/captcha.php");
?>
<div style="width: 100%; padding: 32px; display:grid; grid-template-columns: repeat(2, 1fr); gap:32px;">
<?php
$stmt = $pdo->prepare("SELECT id, img_url, splits FROM captchas");
try {
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $captcha) {
		echo "<div style='display:flex; flex-direction: column; align-items:center'>";
		echo "<div style='display:flex; align-items:center;'>";
		createCaptcha($captcha["img_url"], $captcha["splits"], 8, CaptchaMode::Make);
		echo "</div>";
		echo "<form action='?page=captchas' method='post'>";
		echo "<input type='submit' value='Delete' name='submit_delete'>";
		echo "<input type='hidden' value='".$captcha["id"]."' name='id'>";
		echo "</form>";
		echo "</div>";
	}
}
catch(PDOException $ex) {
	displayPageError($ex->getMessage());
}
?>
</div>
