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

function createGraphColumn($value, $maxValue, $count) {
	echo "<div class='graph-column' style='height:";
	echo $value/$maxValue*100;
	echo "%; width:";
	echo 1/$count*100;
	echo "%'></div>";
}

function createGraph($sql) {
	if (!$pdo) {
		return;
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();
	if (!$result) {
		echo "Invalid Syntax or wront table";
		echo "</div>";
		return;
	}

	$col_count = count($result);
	$max_value = $result[0][0];

	for ($i = 0; $i<$col_count; $i++) {
		$value = $result[$i];

		if ($value > $max_value) {
			$max_value = $value;
		}
	}

	echo '<div class="graph">';
	for ($i = 0; $i<$col_count; $i++) {
		$value = $result[$i][0];
		createGraphColumn($value, $max_value, $col_count);
	}
	echo "</div>";
}

?>
