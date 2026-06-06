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
		echo "<input class='pool-title' value=".$pool['title']."></input>";
		echo "<div class='participants'>";
		foreach($participants as $player) {
			if ($player['pool'] == $pool['id']) {
				echo "<div>";
				echo "<p data-id='".$player['id']."'>".$player['nickname']."</p>";
				if ($editable) {
						echo "<button class='delete'>X</button>";
				}
				echo "</div>";
			}
		}
		echo "</div>";
		echo "</div>";
	}
	echo "</div>";
}

function displayTournament($tournamentId, $editable=false) {
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


	$sql = "SELECT id, nickname, pool FROM participants WHERE tournament = ?";
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
