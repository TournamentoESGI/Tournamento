<?php 
$tables = [];

function createTable($new_table) {
    global $tables;
    $table_name = trim(explode("(", $new_table)[0]);
    $query = "CREATE TABLE IF NOT EXISTS " . $new_table . ";";
    $tables[] = ["name" => $table_name, "query" => $query];
}

function deleteDatabase() {
	global $tables, $pdo;
    foreach (array_reverse($tables) as $table) {
		$pdo->exec("
			SET FOREIGN_KEY_CHECKS = 0;
			DROP TABLE IF EXISTS " . $table["name"] . ";
			SET FOREIGN_KEY_CHECKS = 1;"
		);
    }
}

function makeDatabase() {
    global $tables, $pdo;

    foreach ($tables as $table) {
        $pdo->exec($table["query"]);
    }
}

function test($callable, $excepted='') {
	try {
		$result = $callable();
		if ($excepted === $result || $excepted === '') {
			echo "[OK]";
		}
		else {
			echo "[FAIL]";
		}
	}
	catch (Exception $ex) {
		echo "[FAIL]";
	}
}

function testSQL($sqlQuery) {
	global $pdo;
	try {
		$stmt = $pdo->prepare($sqlQuery);
		$stmt->execute();
		echo "[OK]";
	}
	catch (Exception $ex) {
		displayPageException($ex);
	}
}

?>
