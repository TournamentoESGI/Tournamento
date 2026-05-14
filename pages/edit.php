<?php
verifieCompteConnecte();

/*if (isset($_POST['submit'])) {
	sendDebug($_POST);
	$sql = "";
	foreach($_POST as $key => $value) {
		if (str_starts_with($key, "pool")) {
			$poolData = explode(";", $key);
			sendDebug($poolData);
			$sql = $sql."INSERT INTO pools(id, title, posX, posY) ";
			$sql = $sql."VALUES(".");";
			sendDebug($sql);
		}
	}
}*/


if (!isset($_GET['id'])) {
	displayPageNotFound();
}
$tournament_id = $_GET['id'];
if (!isset($tournament_id) || !is_numeric($tournament_id)) {
	displayPageNotFound();
}


$sql = "SELECT title FROM tournaments WHERE author = ".$_SESSION['id']." AND id = ".$_GET['id'].";";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

if (count($results) == 0) {
	displayPageNotFound();
}

$results = current($results);
$tournament_title = $results['title'];
?>


<div class="editor">
	<div id="anchor">
	</div>
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
	<div class="infos">
		<p>Tournament Editor</p>
		<input type="text" value=<?php echo '"'.$tournament_title.'"'?> placeholder="project name"/>
		<form method="POST" action="<?php echo "?page=edit&id=".$tournament_id?>">
			<div id="tournament-data"></div>
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
