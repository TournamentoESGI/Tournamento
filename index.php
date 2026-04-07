<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

	<?php 
	include_once("./components/basics.php");
	include_once("./components/header.php");
		
		if (!isset($_GET['page'])) {
   			$page = "home";
		} else {
    		$page = $_GET['page'];
		}
		if (!file_exists("./pages/".$page.".php")) {		
    		$page = "404";
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
			if (file_exists("./styles/".$page.".css")) {
				echo '<link rel="stylesheet" href="./styles/'.$page.'.css">';
			}
		?>

	</head>
	<body>
		
		<?php
		include_once("./systems/config.php");
		include_once("./systems/session.php");
		?>
		
		<main>
			<?php
				include_once("./pages/".$page.".php");
			?>
        </main>
        
		<?php include_once("./components/footer.php"); ?>
	</body>
</html>
