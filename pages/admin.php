<?php

$user_role = $_SESSION['role'] ?? null;

if ($user_role !== 'Admin') {
    ?>
	<div class="denied-container">
		<h1>Access denied</h1>
		<button class="denied-button">
			<a href="<?php echo getPagePath('home') ?>">Retour au site</a>
		</button>
	</div>
    <?php
	include_once("./components/footer.php");
    exit;
}

?>


<div class="main-container">
	<div class="container-profil">
		<div class="profil">
			<img src="<?php 
				$stmt = $pdo->prepare("SELECT profil_picture FROM users WHERE id_users = 1");
				$stmt->execute();
				$result = $stmt->fetchAll();
				print_r(current($result[0]));
				?>" alt="profil-picture">
		</div>
		<div class="profil-text">
			<h1><?php 
				$stmt = $pdo->prepare("SELECT username FROM users WHERE id_users = 1");
				$stmt->execute();
				$result = $stmt->fetchAll();
				print_r(current($result[0]));
				?></h1>
			<p><?php 
				$stmt = $pdo->prepare("SELECT email_address FROM users WHERE id_users = 1");
				$stmt->execute();
				$result = $stmt->fetchAll();
				print_r(current($result[0]));
				?></p>
		</div>
		<div class="container-profil-button">
			<img src="./assets/role_icon.png" alt="role-icon">
			<h1><?php 
				$stmt = $pdo->prepare("SELECT role FROM users WHERE id_users = 1");
				$stmt->execute();
				$result = $stmt->fetchAll();
				print_r(current($result[0]));
				?></h1>
		</div>
	</div>
	<div class="container-dashboard">
		<div class="top-container-dashboard">
			<h1>Tableau de bord : Admin / Menu</h1>
			<div class="duo-box-top">
				<button class="button-back"><a href="<?php echo getPagePath("home") ?>">Retour au site</a></button>
				<button class="button-settings"><a href="">Paramètre</a></button>
			</div>
		</div>
		<div class="mid-container-dashboard">
			<h1>Option de navigation :</h1>
			<div class="container-button-nav">
				<button><a href="">Tournoi</a></button>
				<button><a href="">Profil utilisateur</a></button>
				<button><a href="">Statistiques</a></button>
			</div>
		</div>
		<div class="container-separasion"></div>
		<div class="bottom-container-dashboard">
			<div class="top-button">
				<button><a href="">Bannis</a></button>
				<button><a href="">Signalement</a></button>
				<button><a href="">Messages</a></button>
			</div>
			<div class="bottom-button">
				<button><a href="">Système de notes</a></button>
				<button><a href="">Gestion des logs</a></button>
				<button class="button-logout-dashboard"><a href="">Déconnexion</a></button>
			</div>
		</div>
	</div>
</div>
