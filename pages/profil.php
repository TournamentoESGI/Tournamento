<?php
$id = $_SESSION['id'];

$stmt= $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user= $stmt->fetch();

$stmtTournois = $pdo->prepare("SELECT t.*, 'Organisateur' AS mon_role 
FROM tournaments t WHERE t.author = ? ORDER BY t.created_at DESC LIMIT 4");
$stmtTournois->execute([$id]);
$tournoiList = $stmtTournois->fetchAll();

$stmtParis = $pdo->prepare("SELECT p.*, u.username AS nom_participant 
FROM paris p JOIN participants part ON part.id = p.id_participant 
JOIN users u ON u.id = part.user WHERE p.id_parieur = ? ORDER BY p.date DESC LIMIT 4");
$stmtParis->execute([$id]);
$parisList = $stmtParis->fetchAll();
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


            <div class="tournois-boutons">
                <a href="?page=creation_tournoi" class="btn-creation-tournoi">Créer un Tournoi</a>
                <a href="?page=gestion_tournoi" class="btn-gestion-tournoi">Gérer vos Tournois</a>
            </div>


            <div class="profil-infos">
                <h3>Mes informations :</h3>

                <div class="profil-info-ligne">
                    <p class="profil-label">Prénom :</p>
                    <p><?php echo $user['first_name']; ?></p>
                </div>
                <div class="profil-info-ligne">
                    <p class="profil-label">Nom :</p>
                    <p><?php echo $user['last_name']; ?></p>
                </div>
                <div class="profil-info-ligne">
                    <p class="profil-label">Email :</p>
                    <p><?php echo $user['email_address']; ?></p>
                </div>
                <div class="profil-info-ligne">
                    <p class="profil-label">Téléphone :</p>
                    <p><?php echo $user['phone']; ?></p>
                </div>
                <div class="profil-info-ligne">
                    <p class="profil-label">Membre depuis :</p>
                    <p><?php echo date('d/m/Y', strtotime($user['creation_date'])); ?></p>
                </div>
            </div>

            <div class="options-boutons">
                <a href="?page=logout" class="btn-deconnexion">Se déconnecter</a>
                <a href="?page=settings" class="btn-settings">Modifier</a>
            </div>

    </aside>


    <main>
        <div class="container-stats">
            <div class="tournoi-gagner-box">
                <p><?php echo $user ['tournoi_gagner']; ?> Tournois gagnés </p>
            </div>
            <div class="tournoi-organiser-box">
                <p><?php echo $user ['tournoi_organiser']; ?> Tournois organisés </p>
            </div>
            <div class="tournoi-participer-box">
                <p><?php echo $user ['tournoi_participer']; ?> Tournois participés </p>
            </div>
            <div class="paris-gagner-box">
                <p><?php echo $user ['paris_gagner']; ?> Paris gagnés </p>
            </div>
        </div>
        



        <div class="container-solde">
            <div class="solde-header">
                <h2>Solde disponible :</h2>
                <p class="solde-montant"><?php echo $user['current_balance']; ?> €</p>
                <div class="solde-boutons">
                    <button class="btn-deposer">+ Déposer</button>
                    <button class="btn-retirer">- Retirer</button>
                </div>
            </div>  
            
            <div class="solde-stats">
                <p><?php echo $user['balance_en_jeu']; ?> € en jeu</p>
                <p><?php echo $user['balance_gains']; ?> € de gains</p>
                <p><?php echo $user['balance_pertes']; ?> € de pertes</p>
            </div>
        </div>



    <section class="tournoi-section">
        <div class="tournoi-box">

            <div class="tournoi-box-title">
                <img src="./assets/yeux.png" alt="Icone Yeux" class="icone-yeux">
                <h2>● Tournois Visionnées</h2>
            </div>

            <div class="d-flex gap-3">
                <div class="tournoi-card">
                    <div class="img-placeholder"></div>
                    <div class="card-meta">
                        <div class="spect">
                            <img src="./assets/yeux.png" alt="" class="icone-spect">
                            <span>0</span>
                        </div>
                        <p>Tournoi LOL Winter - Demi Final</p>
                    </div>
                </div>
                <div class="tournoi-card">
                    <div class="img-placeholder"></div>
                    <div class="card-meta">
                        <div class="spect">
                            <img src="./assets/yeux.png" alt="" class="icone-spect">
                            <span>0</span>
                        </div>
                        <p>Tournoi Judo 18ème - Quart de Final</p>
                    </div>
                </div>
                <div class="tournoi-card">
                    <div class="img-placeholder"></div>
                    <div class="card-meta">
                        <div class="spect">
                            <img src="./assets/yeux.png" alt="" class="icone-spect">
                            <span>0</span>
                        </div>
                        <p>Tournoi Street basket - Quart de Final</p>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <div class="container-paris">

        <div class="section-paris">
            <p class="section-titre">● Paris récents</p>

            <?php
            if(empty($parisList)) {
                echo "<p>Aucun pari pour l'instant.</p>";
            } else {
                foreach($parisList as $pari) {
                    echo "<div class='paris-ligne'>
                        <div class='paris-info'>
                            <p class='paris-titre'>Pari sur $pari[nom_participant]</p>
                            <p class='paris-date'>$pari[date]</p>
                        </div>
                        <div class='paris-droite'>
                            <p class='paris-montant'>$pari[somme] €</p>
                        </div>
                    </div>";
                }
            }
            ?>

        </div>
    </div>

    <div class="section-tournois">
        <p class="section-titre">● Mes Tournois</p>

            <div class="tournois-grille">
                <?php
                if(empty($tournoiList)) {
                    echo "<p>Aucun tournoi pour l'instant.</p>";
                } else {
                    foreach($tournoiList as $tournoi) {
                        echo "<div class='tournoi-ligne'>
                            <div class='tournoi-info'>
                                <p class='tournoi-nom'>$tournoi[title]</p>
                                <p class='tournoi-date'>$tournoi[start_date]</p>
                            </div>
                        </div>";
                    }
                }
                ?>
            </div>
    </div>

    </main>

</div>