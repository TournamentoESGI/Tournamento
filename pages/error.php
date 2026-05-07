<?php
echo '<script src="./scripts/error.js"> </script>';
echo '<script> cleanPage(); </script>';

echo '<link rel="stylesheet" href="./index.css">';
echo '<link rel="stylesheet" href="./styles/error.css">';

$error_parts = explode(";",$errorPageMessage);
$type = $error_parts[0];
echo "<div class='container'>";
echo "<div class='error'>";
if ($type == "Auto") {
	$err_number = $error_parts[1];
	$err_message = $error_parts[2];
	$err_file = $error_parts[3];
	$err_line = $error_parts[4];
	echo "<h1>Error n°$err_number</h1>";
	echo "<h2>$err_message</h2>";
	echo "<hr/>";
	echo "<h3>In file $err_file</h3>";
	echo "<h3>On line $err_line</h3>";
}
else {
	$error_parts = explode(";",$errorPageMessage);
	$err_message = $error_parts[1];
	echo "<h1>".$err_message."</h1>";
}
echo "</div>";
echo "<div>";
global $debugPageMessage;
foreach(explode("\n",$debugPageMessage) as $debug) {
	echo "<p>$debug</p>";
}
echo "</div>";
echo "</div>";

?>
