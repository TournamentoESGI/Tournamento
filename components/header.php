<header>
    <a href=<?php print getPagePath("")?>><img src="./assets/logo.svg" alt="logo"></a>
    <nav id="nav">
        <ul>
            <?php
            if(isset($_SESSION['id'])) {
                print "<li><a href=".getPagePath("organize").">Organiser un Tournoi</a></li>";
            } else {
                print "<li><a href=".getPagePath("login").">Organiser un Tournoi</a></li>";
            }
            print "<li><a href=".getPagePath("tendance").">Tournois Tendance</a></li>";
            print "<li><a href=".getPagePath("participants").">Participants</a></li>";
            ?>
        </ul>
    </nav>
    <div class="btn-header">
        <?php
        if(isset($_SESSION['id'])) {
            print "<a href=".getPagePath("profil").">Mon Profil</a>";
        } else {
            print "<a href=".getPagePath("login").">Se Connecter</a>";
        }
        ?>
        <button class="burger" id="burger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
<?php include_js('./scripts/utilities.js'); ?>
