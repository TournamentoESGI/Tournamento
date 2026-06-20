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


$sql = "SELECT title, author, status FROM tournaments WHERE id = ".$_GET['id'].";";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();


if (count($results) == 0) {
	displayPageNotFound();
}

$results = current($results);


if (!($results['author']==$_SESSION['id'] || hasAdminRole()) || $results['status']!='edit') {
	displayPageNotFound();
}

$tournament_title = $results['title'];
if (isset($_POST['submit'])) {
	$sql = "DELETE FROM pools WHERE tournament = ".$tournament_id."; UPDATE tournaments SET title = '".$_POST['title']."' WHERE id = ".$tournament_id.";";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$sql = "DELETE FROM participants WHERE tournament = ".$tournament_id.";";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$tournament_title = $_POST['title'];

	$sql = "";
	$valuesPools = [];
	$valuesParticipants = [];
	$valuesPoolsParticipants = [];


	if (isset($_POST['pools'])) {
		foreach($_POST['pools'] as $pool) {
			$infos = [$tournament_id, $pool['id'], "'".$pool['name']."'", round($pool['x']), round($pool['y'])];
			if (isset($pool['participants'])) {
				$valuesPoolsParticipants[$pool['id']] = $pool['participants'];
			}
			array_push($valuesPools, "(".implode(",", $infos).")");
		}

		if (count($valuesPools) > 0) {
			$sql = "INSERT INTO pools(tournament, id, title, posX, posY) VALUES ".implode(", ", $valuesPools).";";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
		}
	}

	if (isset($_POST['participants'])) {
		$participantsData = $_POST['participants'];
		foreach(array_keys($participantsData) as $participantId) {
			$infos = $participantsData[$participantId];
			$participantPool = "NULL";

			foreach(array_keys($valuesPoolsParticipants) as $poolKey) {

				$participantId = strval($participantId);
				$poolKey = strval($poolKey);

				$values = explode(",",$valuesPoolsParticipants[$poolKey]);

				if (in_array($participantId, $values)) {
					$participantPool = $poolKey;
				}
			}

			$infos = [$participantId, "'".$infos['nickname']."'", $infos['user'], $participantPool, $tournament_id];
			array_push($valuesParticipants, $infos);
		}
	}


	if (count($valuesParticipants) > 0) {
		foreach($valuesParticipants as $participant) {
			$sql = "INSERT INTO participants(id, nickname, user, pool, tournament) VALUES (".implode(", ", $participant).");";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
		}
	}

	header('Location: ?page=edit&id='.$tournament_id.'');
}
elseif (isset($_POST['submit_public'])) {
	$sql = "UPDATE tournaments SET status = 'open' WHERE id = ?;";
	$stmt = $pdo->prepare($sql);
	sendDebug($sql);
	$stmt->execute([$tournament_id]);
	
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
		</form>
		<form method="POST" action="<?php echo "?page=edit&id=".$tournament_id?>">
			<button name="submit_public">Open Tournament</button>
		</form>
		<div style='height: 100%; display: flex; flex-direction: column; position: relative'>
			<p>Participants</p>
			<div id="participants-container">
				<?php
					$stmt = $pdo->prepare("SELECT id, nickname, user FROM participants WHERE tournament=?");
					$stmt->execute([$tournament_id]);
					$result = $stmt->fetchAll();
					foreach($result as $participant) {
						echo "<script hidden>
							var participantsListContainer = document.getElementById('participants-container');
							addParticipantToContainer(participantsListContainer, ".$participant['id'].",".$participant["user"].", '".$participant['nickname']."', true)
						</script>";
					}
				?>
			</div>
		</div>
	</div>
</div>
<?php
include_js("./scripts/edit.js");
?>
