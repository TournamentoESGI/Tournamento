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
			displayPageError("Error: Page $page not found");
		}

	?>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tournamento</title>
		<link rel="shortcut icon" href="./assets/flavicon.svg" type="image/x-icon">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="./index.css">

		<?php
			print_r($_SESSION);
			$user_role = $_SESSION['role'] ?? null;
			sendDebug($user_role);
			if (file_exists(DIR_STYLES.$page.".css")) {
				echo '<link rel="stylesheet" href="'.DIR_STYLES.$page.'.css?'.time().'">';
			}
		?>

	</head>
	<body>
		
		<?php
		include_once("./components/header.php");
		include_once("./systems/config.php");
		include_once("./systems/session.php");
		?>
		
		<main id="main">
		<?php
		include_once(DIR_PAGES.$page.".php");
		?>
        </main>

		<?php include_once("./components/footer.php");
		includeJsFiles();
		?>
	</body>
</html>
