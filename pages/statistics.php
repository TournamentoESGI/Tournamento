
<?php
include_once("./components/graphs.php");
?>

<div>
	<div>
		<h1>Utilisateurs inscrits ces derniers mois</h1>
		<?php
		createGraph("SELECT COUNT(*), DATE_FORMAT(creation_date, '%M') FROM users GROUP BY creation_date", $pdo);
		?>
	</div>
	<div>
		<h1>Pages les plus utilisées</h1>
		<?php
		createGraph("SELECT COUNT(*), page FROM logs GROUP BY page", $pdo);
		?>
	</div>
</div>
