<?php

function generateParticipantsList($participants) {
	foreach($participants as $player) {
		echo "<p>".$player["nickname"]."</p>";
	}
}


function addPool($poolName, $poolParticipants) {
	
}

function displayTournament($tournamentId) {
	global $pdo;
	$sql = "SELECT ?, title, posX, posY FROM pools";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$tournamentId]);
	$results = $stmt->fetchAll();

	sendDebug($results);

	$sql = "SELECT id, nickname FROM participants WHERE tournament = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$tournamentId]);
	generateParticipantsList($stmt->fetchAll());

	echo "<div>";

	echo "</div>";
}
?>
