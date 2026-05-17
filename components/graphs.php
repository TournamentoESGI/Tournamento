<?php
function createGraphColumn($value, $maxValue, $minValue, $count, $label="") {
	sendDebug($value-$minValue);
	sendDebug($maxValue-$minValue);
	echo "<div class='graph-column' style='width:";
	echo 1/$count*100;
	echo "%'>";
	echo "<p class='label'>$label</p>";
	echo "<div style='height:";
	echo $maxValue-$minValue==0?100:($value-$minValue)/($maxValue-$minValue)*100;
	echo "%;width:100%; display: flex; flex-direction: column-reverse; align-items: center'>";
	echo "<div class='fill' style='height:100%'></div>";
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


	echo '<div class="graph">';
	if (!$result) {
		echo "<p>Empty results</p>";
		echo "</div>";
		return;
	}
	if (count($result) == 0) {
		echo "Empty results";
		echo "</div>";
		return;
	}

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

	echo '<div class="offset">';
	for ($i = 0; $i<$columnCount; $i++) {
		createGraphColumn($valuesList[$i], $maxValue, $minValue, $columnCount, $labelsList[$i]);
	}
	echo "</div>";
	echo "</div>";
}
?>
