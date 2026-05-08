<div class= login-presentation>

<h1>Tableau de bord : Logs</h1>

<?php
$author = isset($_GET['author']) ? $_GET['author'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

$sql = "SELECT id, author, message, page, date FROM logs";

if ($author && $message) {
    $sql .= " WHERE author LIKE '%$author%' AND message LIKE '%$message%'";
} else if ($author) {
    $sql .= " WHERE author LIKE '%$author%'";
} else if ($message) {
    $sql .= " WHERE message LIKE '%$message%'";
}

$sql .= " ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();
?>

<form method="get" class="logs-filtres">
	
	<input type="text" name="author" placeholder="Utilisateur" value="<?php echo $author; ?>">
	<input type="text" name="message" placeholder="Message" value="<?php echo $message; ?>">

    <button type="submit">Rechercher</button>
    <button type="button" onclick="location.href='?page=logs'">Reset</button>
</form>

	<div class="logs">
		<div class="logs-head logs-row">
			<p>Log-Id:</p>
			<p>Utilisateur:</p>
			<p>Page:</p>
			<p>Message:</p>
			<p>Date:</p>
			<p>Heure:</p>
		</div>

<?php
if (count($results) == 0) {
    echo "<p>Aucun résultat..</p>";
} else {
    foreach ($results as $log) {
		echo "<div class='log logs-row'>";
        echo "<p>".$log['id']."</p>";
        echo "<p>".$log['author']."</p>";
        echo "<p>".$log['page']."</p>";
        echo "<p>".$log['message']."</p>";
        echo "<p>".explode(" ",$log['date'])[0]."</p>";
		echo "<p>".explode(" ",$log['date'])[1]."</p>";
        echo "</div>";
    }
}
?>

	</div>
</div>