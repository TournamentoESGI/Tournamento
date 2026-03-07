<?php
session_start();

include_once "./systems/config.php";
include_once "./components/error.php";
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tournamento</title>
		<link rel="shortcut icon" href="/assets/flavicon.svg" type="image/x-icon">
		<link rel="stylesheet" href="/index.css">
	</head>
	
	<body>
        <?php include_once "./components/header.php"; ?>
        
        <main>
            <?php include_once "./pages/home.php"; ?>
        </main>
        
        <?php include_once "./components/footer.php"; ?>
	</body>
</html>