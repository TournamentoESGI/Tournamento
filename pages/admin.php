<div class="border-space">
	<div class="research-tournament hor">
		<input type="text" placeholder="Rerchercher un tournoi"/>
		<div class="buttons hor">
			<button>Reset</button>
			<button>Rerchercher</button>
		</div>
	</div>
</div>

<div class="graphs hor statistics">
	<div class="newcomers">
		<?php 
			createGraph("SELECT * FROM USERS");
		?>
		<h1>Inscription ces 6 derniers mois</h1>
	</div>
	<div class="tournaments">
		<h1>Tournoi actif ces 6 derniers mois</h1>
	</div>
</div>

<div class="user ver">
	<div class="infos hor">
		<img src="./assets/background.png" alt="Icon" width="100" height="100"/>
		<div class="desc ver">
			<p><b>Profil - Participant sélectionné * actif</b></p>
			<p>adresse@gmail.com</p>
			<hr/>
			<b>
				<ul>
					<li>Tournoi participé: 13 tournois terminé - 2 tournois en cours</li>
					<li>Tournoi organisé : 2 tournois terminé - 3 tournois en brouillons</li>
					<li>Paris effectué : 23 Paris - 72 % de réussite</li>
				</ul>
			</b>
		</div>
	</div>
	<div class="options hor">
		<button>+ de détails</button>
		<button>Supprimer</button>
		<button>Modifier</button>
	</div>
</div>

<div class="border-space">
	<div class="research-participant ver">
		<div class="search hor">
			<div class="filters hor">
				<input type="text"/>
				<select>
					<option>actif</option>
					<option>inactif</option>
				</select>
				<select>
					<option>Paris</option>
					<option>Nice</option>
					<option>Bordeaux</option>
				</select>
			</div>
			<button>Reset</button>
		</div>
	</div>
</div>

<div class="tournaments hor">
	<div class="submissions ver">
		<div class="title hor">
			<h2>Demande de Création de tournoi</h2>
			<button>Agrandir</button>
		</div>
		<div class="content ver">
			<div class="tournament hor">
				<img/>
				<div class="desc">
					<div class="infos hor">
						<p>Spring Battle Valorant 2026</p>
						<p>Soumis par Jean D.</p>
					</div>
					<div class="tags hor">
						<p>Valorant</p>
						<p>24 équipes max</p>					
						<p>Cashprize: 2000</p>					
						<p>4 octobre 2026</p>					
					</div>
				</div>
				<div class="choice">
					<button>Accepter</button>
					<button>Refuser</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php //displayPageError("Error test !") ?>
