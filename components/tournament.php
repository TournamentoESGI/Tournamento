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
	echo "<div class='pools' hidden>";
	foreach($pools as $pool) {
		echo "<div class='pool' data-id='".$pool['id']."' data-name='".$pool['title']."' data-x=".$pool["posX"]." data-y=".$pool["posY"]." style='height: fit-content'>";
			echo "
				<div class='bar'>
				<input class='pool-title' value=".$pool['title']."></input> ".
				($editable?" <button class='add'>+</button>":"")
				. "
				</div>
			";

			echo "<div class='participants'>";
			foreach($participants as $player) {
				if ($player['pool'] == $pool['id']) {
					$isUser = $_SESSION['id'];
					sendDebug($_SESSION);
					sendDebug($player);
					sendDebug($isUser);

					echo "<script hidden>
						var poolContainer = Array.from(document.getElementsByClassName('pool')).filter((pool) => pool.dataset.id == ".$pool['id'].")[0].children[1];
						addParticipantToContainer(poolContainer,".$player["id"].",".$player["user"].",'".$player["nickname"]."', ".($editable?"true":"false").");
					</script>";
				}
			}
			echo "</div>";
		echo "</div>";
	}
	echo "</div>";
}

function displayTournament($tournamentId, $editable=false) {
	echo '<script src="./scripts/tournament_participant.js"></script>';
	echo '<script>
		var userId = '.$_SESSION['id'].'
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
	generatePools($poolsList, $participantsList, $editable);
	
	echo "<h2 style='text-align: center'>".$tournamentInfos["title"]."</h2>";

	echo "<div class='selection'></div>";
	echo "<div class='scaler'>";
	echo "<div class='center'>";
	echo "<div class='anchor'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

	echo "</div>";
	include_js("./scripts/tournament.js");
}
?>
