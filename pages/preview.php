<div style='height: fit-content;'>
<div style='height: 100vh; padding: 16px;'>

<div style=' border: solid var(--c-primary) 2px; height: 100%; border-radius: 16px'>
<?php
if (!array_key_exists('id',$_GET)) {
	displayPageNotFound();
}

$tournamentId = $_GET['id'];
include_once("./components/tournament.php");
displayTournament($tournamentId);
$sql = "SELECT nickname, user FROM participants WHERE tournament = ? AND NOT user = -1 GROUP BY user, nickname";
$stmt = $pdo->prepare($sql);
$stmt->execute([$tournamentId]);
$results = $stmt->fetchAll();

$found = false;
if (verifieCompteRedirige()) {
	$id = $_SESSION['id'];

	foreach($results as $participant) {
		if ($participant["user"] == $id) {
			$found = true;
			break;
		}
	}
	if (!$found && isset($_POST["submit"]) && isset($_POST["nickname"])) {
		$nickname = $_POST['nickname'];
		if (!$found) {
			$sql = "INSERT
				INTO participants(user, pool, tournament, nickname)
				VALUES(?, -1, ?, ?)
			;";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$id, $tournamentId, $nickname]);
			$results = $stmt->fetchAll();
			header('Location: ?page=preview&id='.$tournamentId.'');
			$found = true;
		}
	}
}

?>
</div>

</div>
	<?php
		if (!$found) {
			echo "
			<form action=?page=preview&id=".$tournamentId." method='POST'>
				<input placeholder='Votre surnom' name='nickname'/>
				<button class='btn-inscrire' type='submit' name='submit'>S'inscrire</button>
			</form>
			";
		}
		else {
			echo "<p>Vous êtes inscrit</p>";
		}
	?>
<h2>Participants</h2>
<div class="preview-participants">
    <?php
    foreach($results as $participant) {
        echo "<p>".$participant["nickname"]."</p>";
    }
    ?>
</div>

</div>
