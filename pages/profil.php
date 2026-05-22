<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();
?>
<div class="profil-presentation">

    <aside>
    <div class="container-profil">
            <div class="profil">
                <img src="<?php echo $user['profil_picture']; ?>" alt="profil-picture">
            </div>
            <div class="profil-text">
                <h1><?php echo $user['username']; ?></h1>
                <p><?php echo $user['email_address']; ?></p>
            </div>
            <div class="container-profil-button">
                <img src="./assets/role_icon.png" alt="role-icon">
                <h1><?php echo $user['role']; ?></h1>
            </div>
        </div>
    </aside>

    <div class="solde-container">
        <div class="solde-header">
            <h2>Solde disponible :</h2>
            <div class="solde-boutons">
                <button class="btn-deposer">+ Déposer</button>
                <button class="btn-retirer">- Retirer</button>
            </div>
        </div>
        <p class="solde-montant"><?php echo $user['current_balance']; ?> €</p>
        <div class="solde-stats">
            <p><?php echo $user['balance_en_jeu']; ?> € en jeu</p>
            <p><?php echo $user['balance_gains']; ?> € de gains</p>
            <p><?php echo $user['balance_pertes']; ?> € de pertes</p>
        </div>
    </div>

    <div class="profil-infos">
        <h2>Mes informations</h2>

        <div class="profil-info-ligne">
            <span class="profil-label">Prénom :</span>
            <span><?php echo $user['first_name']; ?></span>
        </div>
        <div class="profil-info-ligne">
            <span class="profil-label">Nom :</span>
            <span><?php echo $user['last_name']; ?></span>
        </div>
        <div class="profil-info-ligne">
            <span class="profil-label">Email :</span>
            <span><?php echo $user['email_address']; ?></span>
        </div>
        <div class="profil-info-ligne">
            <span class="profil-label">Téléphone :</span>
            <span><?php echo $user['phone']; ?></span>
        </div>
        <div class="profil-info-ligne">
            <span class="profil-label">Membre depuis :</span>
            <span><?php echo date('d/m/Y', strtotime($user['creation_date'])); ?></span>
        </div>
        
    </div>
</div>

//rendre le fond plus gris et se fier au figma