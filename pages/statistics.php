
<?php
include_once("./components/graphs.php");
?>

<h1>Utilisateurs inscrits ces derniers mois</h1>

<?php
createGraph("SELECT COUNT(*), DATE_FORMAT(creation_date, '%M') FROM USERS GROUP BY creation_date", $pdo);
?>

<h1>Logs</h1>
<?php
createGraph("SELECT COUNT(*), DATE_FORMAT(creation_date, '%M') FROM USERS GROUP BY creation_date", $pdo);
?>
