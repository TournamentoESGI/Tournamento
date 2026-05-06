
<h1>Logs du serveur</h1>
<div class="logs">
<?php

$sql = "SELECT id, author, message, page, date FROM logs ORDER BY date DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();
?>

<div class='logs-head logs-row'>
<p>Log Id</p>
<p>User</p>
<p>Page</p>
<p>Message</p>
<p>Date</p>
</div>

<?php
foreach($results as $log) {
	echo "<div class='log logs-row'>";
	echo "<p>".$log['id']."</p>";
	echo "<p>".$log['author']."</p>";
	echo "<p>".$log['page']."</p>";
	echo "<p>".$log['message']."</p>";
	echo "<div class='timestamp'>";
	echo "<p>".explode(" ",$log['date'])[0]."</p>";
	echo "<p>".explode(" ",$log['date'])[1]."</p>";
	echo "</div>";
	echo "</div>";
}
?>
</div>
