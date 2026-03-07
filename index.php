<?php
include_once "./components/error.php";
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tournamento</title>
		<link rel="shortcut icon" href="/assets/flavicon.svg" type="image/x-icon">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<link rel="stylesheet" href="./index.css">
	</head>
	<?php
		include_once "./components/header.php";
		include_once "./systems/config.php";
	?>
	<body>
	<?php include_once "./pages/home.php"; ?>
	</body>
	<?php include_once "./components/footer.php"; ?>
</html>
