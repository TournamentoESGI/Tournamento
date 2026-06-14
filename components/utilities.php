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

function createNoCacheSource($path) {
	return $path.'?'.time();
}

function include_js($path) {
	global $include_js_list;
	if (!$include_js_list) {
		$include_js_list = [];
	}
	if (!in_array($path, $include_js_list)) {
		array_push($include_js_list, $path);
	}
}

function sendDebug($message) {
	global $debugPageMessage;
	$clean_message = "";
	if (is_array($message)) {
		$clean_message = json_encode($message);
	}
	else {
		$clean_message = $message;
	}
	$clean_message = str_replace("'", '"', $clean_message);
	$debugPageMessage = $debugPageMessage.$clean_message."\n";
	echo "<script>console.log('".$clean_message."')</script>";
}

function sendLog($message, $tag="") {
    global $pdo;
    $author = $_SESSION['id'] ?? '-1';
    $now = date("Y-m-d H:i:s");
    $page = $_GET['page'] ?? '';

    $sql = "INSERT INTO logs (author, message, date, page, tag) VALUES (:author, :message, :date, :page, :tag)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':author' => $author,
        ':message' => $message,
        ':date' => $now,
        ':page' => $page,
        ':tag' => $tag
    ]);
}
?>
