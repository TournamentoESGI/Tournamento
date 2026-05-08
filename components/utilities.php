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

function sendDebug($message) {
	global $debugPageMessage;
	$debugPageMessage = $debugPageMessage.$message."\n";
	echo "<script>console.log('$message')</script>";
}

function sendLog($message) {
	global $pdo;
	$author = $_SESSION['username']?? 'guest';
	$now = date("Y-m-d H:i:s");
	$page = $_GET['page']?$_GET['page']:'';

	$sql = "INSERT INTO logs(author, message, date, page) VALUES('$author','$message', '$now', '$page');";
	$pdo->exec($sql);
}
?>
