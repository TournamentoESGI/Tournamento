
<?php
include_once("./components/graphs.php");

verifieRoleAdmin();
?>

<h1>Utilisateurs</h1>
<div>
	<div class="graph-section">
		<h2>Utilisateurs inscrits cette année</h2>
		<?php
		createGraph("
			SELECT COUNT(id), DATE_FORMAT(creation_date, '%M') FROM users
			WHERE YEAR(creation_date) = YEAR(CURRENT_TIME)
			GROUP BY DATE_FORMAT(creation_date, '%M') 
		", $pdo);
		?>
	</div>
	<div class="graph-section">
		<h2>Age des utilisateurs</h2>
		<?php
		createGraph("
			SELECT COUNT(id), TIMESTAMPDIFF(YEAR, date_of_birth, CURRENT_TIMESTAMP()) AS age FROM `users`
			GROUP BY age
		", $pdo);
		?>
	</div>
</div>

<h1>Visites et pages</h1>
<div>
	<div class="graph-section">
		<h2>Visites par pages</h2>
		<?php
		createGraph("
			SELECT COUNT(id), page FROM logs
			WHERE tag = 'user_visit'
			GROUP BY page
		", $pdo);
		?>
	</div>
	<div class="graph-section">
		<h2>Actions par pages</h2>
		<?php
		createGraph("
			SELECT COUNT(id), page FROM logs
			WHERE NOT tag = 'user_visit'
			GROUP BY page
		", $pdo);
		?>
	</div>
	<div class="graph-section">
		<h2>Visites par jours du mois</h2>
		<?php
		createGraph("
			SELECT COUNT(id), DATE_FORMAT(day_date, '%b %e') FROM (
				SELECT id, DATE(date) as day_date, TIMESTAMPDIFF(DAY, DATE(date), DATE(CURRENT_TIME)) as diff FROM `logs`
				WHERE tag='user_visit'
			) as sub WHERE diff < 28 GROUP BY day_date
		",$pdo);
		?>
	</div>
</div>
