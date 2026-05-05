<?php
function create_button($text) {
	echo "<button>".$text."</button>";
}

function getPagePath($path) {
	if ($path === ""){
		return "./?";
	}
	else {
		return "./?page=".$path;
	}
}

function createLink($path, $text) {
	echo "<a href=".getPagePath($path)."></a>";
}

function include_js($path) {
	global $include_js_list;
	if (!in_array($path, $include_js_list)) {
		array_push($include_js_list, $path);
	}
}

function sendLog($message) {
	global $pdo;
	$author = "guest";

	$sql = "INSERT INTO logs(author, message) VALUES($author,$message)";
	$pdo->exec($sql);
}
?>
