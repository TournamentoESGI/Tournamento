<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournamento</title>
    <link rel="shortcut icon" href="/assets/flavicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/index.css">
</head>
<body>
    <header>
        <a href="/index.php"><img src="/assets/logo.svg" alt="logo"></a>
        <nav>
            <ul>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="/pages/config_tournoi.php">Organiser un Tournoi</a></li>
                <?php else: ?>
                    <li><a href="/pages/login.php">Organiser un Tournoi</a></li>
                <?php endif; ?>
                <li><a href="/pages/tendance.php">Tournois Tendance</a></li>
                <li><a href="/pages/participants.php">Participants</a></li>
            </ul>
        </nav>
        <div class="btn-header">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/pages/profil.php">Mon Profil</a>
            <?php else: ?>
                <a href="/pages/login.php">Connexion</a>
            <?php endif; ?>
        </div>
    </header>
