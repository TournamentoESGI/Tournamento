<?php

function display_page_error($error_message) {
	echo "<h1>Erreur</h1>";
	echo "<p>".$error_message."</p>";
	include_once(__DIR__ . "/footer.php");
    die();
}

?>

