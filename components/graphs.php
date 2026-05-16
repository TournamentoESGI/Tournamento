<?php
function createGraphColumn($value, $maxValue, $count, $label="") {
	echo "<div class='graph-column' style='width:";
	echo 1/$count*100;
	echo "%'>";
	echo "<p class='label'>$label</p>";
	echo "<div style='height: 100%; width:100%; display: flex; flex-direction: column-reverse; align-items: center'>";
	echo "<div class='fill' style='height:";
	echo $value/$maxValue*100;
	echo "%'></div>";
	echo "<p class='value'>$value</p>";
	echo "</div>";
	echo "</div>";
}

function createGraph($sql,$pdo) {
	if (!$pdo) {
		return;
	}
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	}
	catch (PDOException $ex) {
		displayPageException($ex);
	}


	if (!$result) {
		echo "Invalid Syntax or wrong table";
		return;
	}
	if (count($result) == 0) {
		echo "Empty results";
		return;
	}

	sendDebug($result);

	$valueKey = array_keys($result[0])[0];
	$labelKey = array_keys($result[0])[1];

	$columnCount = count($result);
	$maxValue = (int)$result[0][$valueKey];
	$minValue = (int)$result[0][$valueKey];

	$valuesList = [];
	$labelsList = [];

	for ($i = 0; $i<$columnCount; $i++) {
		array_push($valuesList, $result[$i][$valueKey]);
		array_push($labelsList, $result[$i][$labelKey]);

		$value = $valuesList[$i];
		if ($value > $maxValue) {
			$maxValue = $value;
		}
		if ($value < $minValue) {
			$minValue = $value;
		}
	}

	sendDebug($valuesList);
	sendDebug($labelsList);

	echo '<div class="graph">';
	for ($i = 0; $i<$columnCount; $i++) {
		createGraphColumn($valuesList[$i], $maxValue, $columnCount, $labelsList[$i]);
	}
	echo "</div>";
}
?>
