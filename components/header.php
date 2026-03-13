<header>
	<a href=<?php print getPagePath("")?>><img src="./assets/logo.svg" alt="logo"></a>
    <nav>
        <ul>
			<?php
			if(isset($_SESSION['user_id'])) {
				print "<li><a href=".getPagePath("config_tournoi").">Organiser un Tournoi</a></li>";
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
		if(isset($_SESSION['user_id'])) {
			print "<a href=".getPagePath("profil").">Mon Profil</a>";
		}
		else {
			print "<a href=".getPagePath("login").">Se Connecter</a>";
		}
		?>
    </div>
</header>
