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

if (isset($_POST['submit'])) {
	$sql = "DELETE FROM pools WHERE tournament = ".$tournament_id.";";
	foreach($_POST as $key => $value) {
		if (str_starts_with($key, "pool")) {
			$poolData = explode(";", $key);
			$id = explode(";", explode("id:",$key)[1])[0];
			$posX = explode(";", explode("x:",$key)[1])[0];
			$posY = explode(";", explode("y:",$key)[1])[0];
			$title = explode(";", explode("title:",$key)[1])[0];
			$sql = $sql.getPoolUpsertSQL($id, $posX, $posY, $title);
		}
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
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
			<div id="tournament-data">
				<?php
				$sql = "SELECT id, title, posX, posY FROM POOLS";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$results = $stmt->fetchAll();
				foreach($results as $pool) {
					echo "<p hidden>pool;id:".$pool['id'].";title:".$pool['title'].";posX:".$pool['posX'].";posY:".$pool['posY']."</p>";
				}
				?>
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
