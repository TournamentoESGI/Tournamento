
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
$sql = "SELECT nickname FROM participants WHERE tournament = ? AND NOT user = -1 GROUP BY user";
$stmt = $pdo->prepare($sql);
$stmt->execute([$tournamentId]);
$results = $stmt->fetchAll();

?>
</div>

</div>

	<form action="?page=preview">
		<button>S'inscrire</button>
	</form>
	<?php
		foreach($results as $participant) {
			sendDebug($participant);
			echo "<p>".$participant["nickname"]."</p>";
		}
	?>
	<li>
		
	</li>
</div>
