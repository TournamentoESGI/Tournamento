<?php
ob_end_clean();

$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $pdo->query("
    SELECT u.id, u.username, u.profil_picture, COUNT(DISTINCT pa.id) AS nbTournois, COUNT(DISTINCT pw.id) AS nbVictoires,
    (COUNT(DISTINCT pa.id) * 5) +(COUNT(DISTINCT pw.id) * 20) AS points
    FROM users u
    LEFT JOIN participants pa ON pa.user = u.id
    LEFT JOIN participants pw ON pw.user = u.id AND pw.position = 1
    GROUP BY u.id, u.username, u.profil_picture
    ORDER BY points DESC
");
$tousLesUtilisateurs = $stmt->fetchAll();

$listeFiltrer = [];
foreach ($tousLesUtilisateurs as $user) {
    if ($search == '' || strpos($user['username'], $search) !== false) {
        $listeFiltrer[] = $user;
    }
}

header('Content-Type: application/json');
echo json_encode($listeFiltrer);
die();