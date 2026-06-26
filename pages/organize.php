<?php
verifieCompteConnecte();

$id = $_SESSION['id'];

sendDebug($_POST);

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	if ($name!="" && $description!="") {
		$sql = "INSERT INTO tournaments(author, title, description) VALUES(?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$id, $name, $description]);
	}
}

?>


<form id="organize" action="?page=organize" method="post">
	<input placeholder="Tournament name" name="name"></input>
	<textarea placeholder="Tournament description" name="description" type="text"></textarea>
	<button type="submit" name="submit">Create</button>
</form>

<div class="list">
	<?php
		$stmtTournois = $pdo->prepare("
		SELECT id, title, description, 'Organisateur'
		FROM tournaments 
		WHERE author = ?
		ORDER BY created_at DESC LIMIT 4
		");
		$stmtTournois->execute([$id]);
		$tournoisList = $stmtTournois->fetchAll();
		foreach($tournoisList as $tournoi) {
			$link = "?page=preview&id=".$tournoi['id'];
			echo "<a href=".$link.">".
				"<h2>".$tournoi['title']."</h2>".
				"<p>".$tournoi['description']."</p>".
			"</a>";
		}
	?>
</div>
