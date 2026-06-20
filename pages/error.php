<?php
global $runner;
global $errorPageMessage;

$error_parts = explode(";",$errorPageMessage);
$type = $error_parts[0];

if ($runner != "cli") {
	echo '<script src="./scripts/error.js"> </script>';
	echo '<script> cleanPage(); </script>';

	echo '<link rel="stylesheet" href="./index.css">';
	echo '<link rel="stylesheet" href="./styles/error.css">';
	echo "<main>";
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
		echo "<div class=";
		echo $type=="404"?"notfound":$type;
		echo ">";
		echo "<h1>".$err_message."</h1>";
		echo "<p>Page non trouvé, vous allez être rediriger..</p>";
		echo "<script>setTimeout(() => { window.location.replace('?page=home'); }, 5000);</script>";
		echo "</div>";
	}
}
else {
	echo "\n";
	echo $error_parts[1];
	echo "\n";
	echo $error_parts[2];
	echo "\n";
	echo $error_parts[3];
	echo "\n";
	echo $error_parts[4];
	echo "\n";
}

global $debugPageMessage;
if ($runner != "cli") {
	if ($debugPageMessage) {
		echo "<h1>Debugger :</h1>";
		echo "<div class='debug'>";
		if (str_contains($debugPageMessage,"\n;")) {
			$debugPageMessage = explode("\n;",$debugPageMessage);
			array_pop($debugPageMessage);
			foreach($debugPageMessage as $debug) {
				echo "<div class='line";
				if (str_contains($debug, "\n")) {
					echo " json'><pre>";
					foreach(explode("\n",$debug) as $jsonLine) {
						echo "<p>".$jsonLine."</p>";
					}
					echo "</pre></div>";
				}
				else {
					echo "'>";
					echo "<p>".$debug."</p>";
					echo "</div>";
				}
			}
		}
		echo "</div>";
	}
	echo "</div>";
	echo "</div>";
	echo "</main>";
}
else {
	echo $debugPageMessage;
}

?>
