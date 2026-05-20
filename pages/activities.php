<?php
$sql = "
SELECT username, page, DATE_FORMAT(logs.date, '%H:%i') as log_date FROM users
JOIN logs ON users.id=logs.author
WHERE logs.tag = 'user_visit' AND DAY(logs.date) = DAY(CURRENT_DATE)
GROUP BY username, log_date, page
;";


$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

$users = [];

foreach($results as $log) {
	$username = $log['username'];
	$date = $log['log_date'];
	$page = $log['page'];
	$userLogs = [];
	if (array_key_exists($username, $users)) {
		$userLogs = $users[$username];
	}
	if (count($userLogs) > 0) {
		if (end($userLogs)["page"] != $page) {
			if (end($userLogs)["time"] != $date) {
				array_push($userLogs, ["time" => $date, "page" => $page]);
			}
		}
	}
	else {
		array_push($userLogs, ["time" => $date, "page" => $page]);
	}
	$users[$username] = $userLogs;
}

function getTimestampInMinutes($time) {
	$minutes = substr($time, 3, 2);
	$hours = substr($time, 0, 2);
	return $hours*60+$minutes;
}



echo "<div class='activities-container'>";
	echo "<div class='hours'>";
	for($hour=0; $hour<24; $hour++) {
		echo "<p>".$hour."</p>";
	}
	echo "</div>";

	$minutesInDay = 24*60;
	foreach(array_keys($users) as $username) {
		echo "<div class='user'>";
			echo "<div class='planning'>";

			$activities = $users[$username];
			array_unshift($activities, ["time" => "00:00", "page" => " "]);
			array_push($activities, ["time" => "24:00", "page" => " "]);

			for($i=1; $i<count($activities); $i++) {
				$activity = $activities[$i];
				$timestamp = $activity['time'];
				$page = $activity['page'];
				$minutesOfDay = getTimestampInMinutes($timestamp);
				$minutesOfDayPrevious = getTimestampInMinutes($activities[$i-1]['time']);
				$percentInDay = ($minutesOfDay-$minutesOfDayPrevious)/$minutesInDay;
				echo "<div class='page' style='height: ".($percentInDay*100)."%'>";
					echo "<p>".$page."</p>";
				echo "</div>";
				sendDebug($activity);
			}
			echo "</div>";
		echo "</div>";
	}

	sendDebug($users);
echo "</div>";


?>
