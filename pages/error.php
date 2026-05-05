<?php
echo "</main>";
echo '<script src="./scripts/error.js"> </script>';
echo '<script>
cleanPage();
</script>';
echo '<link rel="stylesheet" href="./index.css">';
$error_parts = explode(":",$errorPageMessage);
if (count($error_parts) > 2) {
    $error_code = $error_parts[0];
    $error_type = $error_parts[1];
    $error_message = $error_parts[2];

	echo "<div style='display:flex; flex-direction: column; padding: 16px;'>";
    echo "<h1>";
    echo "Erreur ".$error_code;
    echo "</h1>";
    
    echo "<p>";
    echo $error_type;
    echo "</p>";
    
    echo "<p>";
	echo $error_message;
	echo "</p>";

	echo "<button style='width: fit-content' id='errorButton'>See full error</button>";
	echo "<div id='errorContainer'>";
	echo "<p>$errorPageMessage</p>";
	echo "</div>";
	echo "</div>";
}
else {
    echo "<h1>".$errorPageMessage."</h1>";
}
?>
