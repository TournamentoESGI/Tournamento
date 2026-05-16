
<?php
include_once("./components/graphs.php");
?>

<div class="graph-section">
	<h2>Utilisateurs inscrits cette année</h2>
	<?php
	createGraph("SELECT COUNT(*), DATE_FORMAT(creation_date, '%M') FROM users GROUP BY creation_date", $pdo);
	?>
</div>
<div class="graph-section">
	<h2>Age des utilisateurs</h2>
	<?php
	createGraph("SELECT COUNT(*), TIMESTAMPDIFF(YEAR, date_of_birth, CURRENT_TIMESTAMP()) AS age FROM `users` GROUP BY age", $pdo);
	?>
</div>
<div class="graph-section">
	<h2>Visites par pages</h2>
	<?php
	createGraph("SELECT COUNT(*), page FROM logs WHERE tag = 'user_visit' GROUP BY page", $pdo);
	?>
</div>
<div class="graph-section">
	<h2>Actions par pages</h2>
	<?php
	createGraph("SELECT COUNT(*), page FROM logs WHERE NOT tag = 'user_visit' GROUP BY page", $pdo);
	?>
</div>

<div class="graph-section">
	<h2>Visites par jours</h2>
	<?php
	createGraph("
		SELECT COUNT(id), DAY(day_date) FROM (
			SELECT id, DATE(date) as day_date, TIMESTAMPDIFF(DAY, DATE(date), DATE(CURRENT_TIME)) as diff FROM `logs`
			WHERE tag='user_visit'
		) as sub WHERE diff < 28 GROUP BY day_date"
	,$pdo);
	?>
</div>
