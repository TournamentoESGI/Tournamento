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
	echo "<a href=".getPagePath($path)."</a>";
}
?>
