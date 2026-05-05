
<h1>Logs du serveur</h1>
<div class="logs">
<?php

$sql = "SELECT id, author, message, date FROM logs;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();
foreach($results as $log) {
	echo "<div class='log'>";
	echo "<div class='content'>";
	echo "<div class='info'>";
	echo "<p>".$log['id']."</p>";
	echo "<p>".$log['author']."</p>";
	echo "</div>";
	echo "<p>".$log['message']."</p>";
	echo "</div>";
	echo "<div>";
	echo "<p>".$log['date']."</p>";
	echo "</div>";
	echo "</div>";

}
?>
</div>
