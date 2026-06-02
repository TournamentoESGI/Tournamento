<?php
verifieRoleAdmin();
$stmt = $pdo->prepare("SELECT username, email_address, profil_picture, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$admin = $stmt->fetch();
?>

<div class="admin-presentation">
    <div class="main-container">

        <div class="container-profil">
            <div class="profil">
                <img src="<?= $admin['profil_picture'] ?>" alt="profil-picture">
            </div>
            <div class="profil-text">
                <h1><?= $admin['username'] ?></h1>
                <p><?= $admin['email_address'] ?></p>
            </div>
            <div class="container-profil-button">
                <img src="./assets/role_icon.png" alt="role-icon">
                <h1><?= $admin['role'] ?></h1>
            </div>
        </div>

        <div class="container-dashboard">
            <div class="top-container-dashboard">
                <h1>Tableau de bord : Admin / Menu</h1>
                <div class="duo-box-top">
                    <button class="button-back"><a href="<?= getPagePath("home") ?>">Retour au site</a></button>
                    <button class="button-settings"><a href="<?= getPagePath("settings") ?>">Paramètres</a></button>
                </div>
            </div>

            <div class="mid-container-dashboard">
                <h1>Option de navigation :</h1>
                <div class="container-button-nav">
                    <button><a href="<?= getPagePath("statistics") ?>">Tournoi</a></button>
                    <button><a href="<?= getPagePath("statistics") ?>">Profil utilisateur</a></button>
                    <button><a href="<?= getPagePath("statistics") ?>">Statistiques</a></button>
                </div>
            </div>

            <div class="bottom-container-dashboard">
                <div class="top-button">
                    <button><a href="<?= getPagePath("") ?>">Bannis</a></button>
                    <button><a href="<?= getPagePath("") ?>">Signalement</a></button>
                    <button><a href="<?= getPagePath("") ?>">Messages</a></button>
                </div>
                <div class="bottom-button">
                    <button><a href="<?= getPagePath("") ?>">Système de notes</a></button>
                    <button><a href="<?= getPagePath("logs") ?>">Gestion des logs</a></button>
                    <button class="button-logout-dashboard"><a href="<?= getPagePath("logout") ?>">Déconnexion</a></button>
                </div>
            </div>
        </div>

    </div>
</div>