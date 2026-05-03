<?php
function createGraphColumn($value, $maxValue, $count) {
	echo "<div class='graph-column' style='height:";
	echo $value/$maxValue*100;
	echo "%; width:";
	echo 1/$count*100;
	echo "%'></div>";
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
		$msg = $ex->getMessage();
		if (str_contains($msg, "SQLSTATE")) {
			$clean = substr(explode("SQLSTATE", $ex->getMessage())[1], 9);
			if (str_contains($clean, "1054")) {
				$clean = explode(" in",explode("1054 ", $clean)[1])[0];
			}
			else if (str_contains($clean, "1064")) {
				$sep = "; check the manual that corresponds to your MySQL server version for the right syntax to use";
				$clean = explode("1064", $clean)[1];
				$clean = explode($sep, $clean)[0].explode($sep, $clean)[1];
			}
			echo $clean;
		}
		else {
			echo $ex->getMessage();
		}
		return;
	}

	if (!$result) {
		echo "Invalid Syntax or wrong table";
		return;
	}

	if (count($result) == 0) {
		echo "Empty results";
		return;
	}

	$col_count = count($result);
	$max_value = (int)current($result[0]);

	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)current($result[$i]);
		if ($value > $max_value) {
			$max_value = $value;
		}
	}

	echo '<div class="graph">';
	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)current($result[$i]);
		createGraphColumn($value, $max_value, $col_count);
	}
	echo "</div>";
}
?>
