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
            <a href="/pages/login.php">Se Connecter</a>
        <?php endif; ?>
    </div>
</header>