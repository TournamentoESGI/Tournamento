<?php
verifieCompteConnecte();

$tournament_id = $_GET['id'];

if (!isset($_GET['id'])) {
	displayPageError("No access");
}
$sql = "SELECT * FROM tournaments WHERE author = ".$_SESSION['id']." AND id = ".$_GET['id'].";";
sendDebug($sql);
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();
if (count($results) == 0) {
	displayPageError("No access");
}

?>

<div class="editor">
	<div id="anchor">
	</div>
</div>
<div class="tool-container">
	<div class="toolbar">
		<button>
			<h1> S </h1>
		</button>
		<button id="button-create">
			<h1> P </h1>
		</button>
	</div>
</div>
<div class="infos-container">
	<div class="infos">
		<p>Tournament Editor</p>
		<input type="text" placeholder="project name"/>
		<p>Participants</p>
		<div class="participants-container">
			<?php
				$stmt = $pdo->prepare("SELECT nickname FROM participants");
				$stmt->execute();
				$result = $stmt->fetchAll();
				foreach($result as $participant) {
					echo "<div class='participant'>";
					echo $participant['nickname'];
					echo "</div>";
				}
			?>
		</div>
	</div>
</div>
<?php
include_js("./scripts/edit.js");
?>
