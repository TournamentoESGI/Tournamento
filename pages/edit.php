<?php
verifieCompteConnecte();

if (!isset($_GET['id'])) {
	displayPageNotFound();
}
$tournament_id = $_GET['id'];
if (!isset($tournament_id) || !is_numeric($tournament_id)) {
	displayPageNotFound();
}

function getPoolUpsertSQL($id, $posX, $posY, $title) {
	global $tournament_id;
	$result = "INSERT INTO pools(number, tournament, posX, posY, title) ";
	$result = $result.'VALUES('.$id.', '.$tournament_id.', '.$posX.', '.$posY.', "'.$title.'");';
	return $result;
}

$sql = "SELECT title, author FROM tournaments WHERE id = ".$_GET['id'].";";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();


if (count($results) == 0 && ($results['author']==$_SESSION['id'] || hasAdminRole())) {
	displayPageNotFound();
}

$results = current($results);
$tournament_title = $results['title'];
if (isset($_POST['submit'])) {
	sendDebug($_POST);
	$sql = "DELETE FROM pools WHERE tournament = ".$tournament_id.'; UPDATE tournaments SET title = "'.$_POST['title'].'" WHERE id = '.$tournament_id.';';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	sendDebug($sql);
	$tournament_title = $_POST['title'];
	
	foreach($_POST['pools'] as $pool) {
		sendDebug($pool);
		$sql = "INSERT INTO pools(tournament, id, title, posX, posY) VALUES(".$tournament_id.",".$pool['id'].",'".$pool['name']."',".$pool['x'].",".$pool['y'].");";
		sendDebug($pool);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
	}
}
?>

<div class="editor">

<?php

include_once('./components/tournament.php');
displayTournament($tournament_id, true)

?>
</div>
<div class="tool-container">
	<div class="toolbar">
		<button>
			<h1> S </h1>
		</button>
		<button id="button-create">
			<h1> P </h1>
		</button>
	</div>
</div>
<div class="infos-container">
	<div id="infos">
		<p>Tournament Editor</p>
		<form method="POST" action="<?php echo "?page=edit&id=".$tournament_id?>">
			<input type="text" name='title' value=<?php echo '"'.$tournament_title.'"'?> placeholder="project name"/>
			<div id="tournament-data">
			</div>
			<button name="submit" type="submit" onclick="saveTournament()">Save</button>
		<form>
		<p>Participants</p>
		<div id="participants-container">
			<?php
				$stmt = $pdo->prepare("SELECT nickname FROM participants WHERE tournament=?");
				$stmt->execute([$tournament_id]);
				$result = $stmt->fetchAll();
				foreach($result as $participant) {
					echo "<div class='participant'>";
					echo $participant['nickname'];
					echo "</div>";
				}
			?>
		</div>
	</div>
</div>
<?php
include_js("./scripts/edit.js");
?>
