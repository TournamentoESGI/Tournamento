<!DOCTYPE html>
<html lang="fr">
	<?php
	include_once("components/basics.php");
	?>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tournamento</title>
		<link rel="shortcut icon" href="./assets/flavicon.svg" type="image/x-icon">
		<link rel="stylesheet" href="./index.css">
	</head>
	<body>
		
		<?php include_once "./components/header.php";
		if (is_null($_GET['page'])) {
			$page = "home";
		}
		else {
			$page = $_GET['page'];
		}
		if (!file_exists("./pages/".$page.".php")) {
			$page = "404";
		}

		session_start();
		include_once "./systems/config.php";
		?>
		
		<main>
			<?php
				include_once "./pages/".$page.".php";
			?>
        </main>
        
        <?php include_once "./components/footer.php"; ?>
	</body>
</html>
