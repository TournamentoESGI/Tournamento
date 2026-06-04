<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<?php
	session_start();
	include_once("./systems/constants.php");
	$include_js_list = [];

	function includeJsFiles() {
		global $include_js_list;
		foreach($include_js_list as $js_path) {
				echo "<script src='".$js_path."?".time()."'></script>";
		}
	}

	include_once("./components/error.php");
	include_once("./components/utilities.php");
		if (!isset($_GET['page'])) {
   			$page = "home";
		} else {
    		$page = $_GET['page'];
		}
		if (!file_exists(DIR_PAGES.$page.".php")) {
			displayPageNotFound();
		}

	?>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tournamento</title>
		<link rel="shortcut icon" href="./assets/flavicon.svg" type="image/x-icon">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<?php
			echo "<link rel='stylesheet' href=".createNoCacheSource("./index.css").">";
			echo "<link rel='stylesheet' href=".createNocacheSource("./components.css").">";
		?>

		<?php
			if (file_exists(DIR_STYLES.$page.".css")) {
				echo '<link rel="stylesheet" href="'.createNoCacheSource(DIR_STYLES.$page.'.css').'">';
			}
		?>

	</head>
	<body>
		
		<?php
		include_once("./components/header.php");
		include_once("./systems/config.php");
		?>
		
		<main id="main">
		<?php
		if ($page !== "home") {
			sendLog("Visit $page", "user_visit");
		}
		include_once(DIR_PAGES.$page.".php");
		?>
        </main>

		<?php 
		if ($page != "edit") {
			include_once("./components/footer.php");
		}
		includeJsFiles();
		?>
	</body>
</html>
