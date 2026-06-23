<?php

function displayPool($title, $x, $y) {
	echo "<div class='pool' data-name='".$title."' data-x=".$x." data-y=".$y." style='height: fit-content'>";
	echo "</div>";
}

function generateParticipantsList($participants) {
	echo "<div class='participants 'hidden>";
	foreach($participants as $player) {
		echo "<p>".$player["nickname"]."</p>";
	}
	echo "</div>";
}


function generatePools($pools, $participants, $editable=false) {
	$isEditable = ($editable?"true":"false");
	foreach($pools as $pool) {
		echo "<script>
			var tournament = document.getElementsByClassName('anchor')[0];
			console.log(tournament)
			addPoolToTournament(tournament, ".$pool['id'].",'".$pool['title']."',".$pool['posX'].",".$pool['posY'].",".$isEditable.")
		</script>";

		foreach($participants as $player) {
			if ($player['pool'] == $pool['id']) {
				echo "<script hidden>
					var poolContainer = Array.from(document.getElementsByClassName('pool')).filter((pool) => pool.dataset.id == ".$pool['id'].")[0].getElementsByClassName('participants')[0];
					addParticipantToContainer(poolContainer,".$player["id"].",".$player["user"].",'".$player["nickname"]."', ".$isEditable.");
				</script>";
			}
		}
	}
}

function displayTournament($tournamentId, $editable=false) {
	$id = isset($_SESSION['id'])?$_SESSION['id']:-1;

	echo '<script src="'.createNoCacheSource("./scripts/tournament_components.js").'"></script>';
	echo '<script>
		var userId = '.$id.'
	</script>';

	echo "<div class='tournament-display' tabindex='0'  data-edit=".($editable?"true":"false").">";

	global $pdo;
	
	$sql = "SELECT title FROM tournaments WHERE id = ".$tournamentId.";";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$tournamentInfos = current($stmt->fetchAll());

	$sql = "SELECT id, title, posX, posY FROM pools";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$poolsList = $stmt->fetchAll();


	$sql = "SELECT id, user, nickname, pool FROM participants WHERE tournament = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$tournamentId]);
	$participantsList = $stmt->fetchAll();

	generateParticipantsList($participantsList);
	
	echo "<h2 style='text-align: center'>".$tournamentInfos["title"]."</h2>";

	echo "<div class='selection'></div>";
	echo "<div class='scaler'>";
	echo "<div class='center'>";
	echo "<div class='anchor'>";
	generatePools($poolsList, $participantsList, $editable);
	echo "</div>";
	echo "</div>";
	echo "</div>";

	echo "</div>";
	include_js("./scripts/tournament.js");
}
?>
