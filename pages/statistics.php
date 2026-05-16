
<?php
include_once("./components/graphs.php");
?>

<div>
	<div class="graph-section">
		<h2>Utilisateurs inscrits ces derniers mois</h2>
		<?php
		createGraph("SELECT COUNT(*), DATE_FORMAT(creation_date, '%M') FROM users GROUP BY creation_date", $pdo);
		?>
	</div>
	<div class="graph-section">
		<h2>Pages les plus utilisées</h2>
		<?php
		createGraph("SELECT COUNT(*), page FROM logs GROUP BY page", $pdo);
		?>
	</div>
</div>
