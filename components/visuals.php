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
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();
	if (!$result) {
		echo "Invalid Syntax or wrong table";
		echo "</div>";
		return;
	}

	$col_count = count($result);
	$max_value = (int)$result[0][0];

	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)$result[$i][0];

		if ($value > $max_value) {
			$max_value = $value;
		}
	}

	echo '<div class="graph">';
	for ($i = 0; $i<$col_count; $i++) {
		$value = (int)$result[$i][0];
		createGraphColumn($value, $max_value, $col_count);
	}
	echo "</div>";
}

function createCaptcha($img_path, $nb_piece) {
	echo "<div class='captcha'>";
	$size = 1/$nb_piece*100;
	for ($y=0; $y<$nb_piece; $y++) {
		for ($x=0; $x<$nb_piece; $x++) {
			
			echo "<div class='piece' ";
			echo "style='";
			echo "left:".$x*$size."%;";
			echo "top:".$y*$size."%;";
			echo "width:".$size."%;";
			echo "height:".$size."%;";
			echo "'>";

				echo "<div style='";
				echo "background-image:url(".$img_path.");";
				echo "width:100%;height:100%;";
				echo "background-position:".$x*$size."%".$y*$size."%;";
				echo "'></div>";
			
			echo "</div>";
		}
	}
	echo "</div>";
}

?>
