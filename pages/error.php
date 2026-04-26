<?php
$error_parts = explode(":",$errorPageMessage);
$error_code = $error_parts[0];
$error_type = $error_parts[1];
$error_message = $error_parts[2];

echo "<h1>";
echo "Erreur ".$error_code;
echo "</h1>";

echo "<p>";
echo $error_type;
echo "</p>";

echo "<p>";
echo $error_message;
echo "</p>";
?>
