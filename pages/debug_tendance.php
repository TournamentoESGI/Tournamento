<?php
echo "<h2>Tournaments</h2>";
$r = $pdo->query("SELECT id, title, status FROM tournaments")->fetchAll();
echo "<pre>"; print_r($r); echo "</pre>";

echo "<h2>Participants</h2>";
$r = $pdo->query("SELECT id, user, tournament, nickname FROM participants")->fetchAll();
echo "<pre>"; print_r($r); echo "</pre>";

echo "<h2>Paris</h2>";
$r = $pdo->query("SELECT id, id_participant, id_parieur, somme FROM paris")->fetchAll();
echo "<pre>"; print_r($r); echo "</pre>";