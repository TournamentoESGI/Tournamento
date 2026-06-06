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


function generatePools($pools, $participants) {
	echo "<div class='pools' hidden>";
	foreach($pools as $pool) {
		echo "<div class='pool' data-name='".$pool['title']."' data-x=".$pool["posX"]." data-y=".$pool["posY"]." style='height: fit-content'>";
		foreach($participants as $player) {
			if ($player['pool'] == $pool['id']) {
				echo "<p data-id='".$player['id']."'>".$player['nickname']."</p>";
			}
		}
		echo "</div>";
	}
	echo "</div>";
}

function displayTournament($tournamentId) {
	echo "<div class='tournament-display' tabindex='0'>";

	global $pdo;
	$sql = "SELECT id, title, posX, posY FROM pools";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$poolsList = $stmt->fetchAll();

	$sql = "SELECT id, nickname, pool FROM participants WHERE tournament = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$tournamentId]);
	$participantsList = $stmt->fetchAll();

	generateParticipantsList($participantsList);
	generatePools($poolsList, $participantsList);
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
