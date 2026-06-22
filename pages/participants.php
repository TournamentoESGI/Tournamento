<?php
$pageCourante = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$parPage = 50;

$stats = $pdo->query("
    SELECT
        (SELECT COUNT(id) FROM users) AS totalUsers,
        (SELECT COUNT(id) FROM participants) AS totalParticipants,
        (SELECT COUNT(id) FROM tournaments) AS totalTournaments
")->fetch();

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

$topTrois = array_slice($tousLesUtilisateurs, 0, 3);
?>

<div class="participants-banner">
    <p class="participants-tag">Communauté</p>
    <h1>Les meilleurs Participants,</h1>
    <h2>Le top des guerriers de Tournamento</h2>
    <p>Voici le classement mensuel de nos meilleurs combattants. Gagner et participer à des tournois vous fait gagner des points.</p>

    <div class="participants-stats">
        <div><p><?php echo $stats['totalUsers']; ?></p><p>Utilisateurs</p></div>
        <div><p><?php echo $stats['totalParticipants']; ?></p><p>Participations</p></div>
        <div><p><?php echo $stats['totalTournaments']; ?></p><p>Tournois joués</p></div>
    </div>
</div>

<div class="participants-top">
    <p class="participants-badge">Classement - Les meilleurs joueurs du mois !</p>

    <div class="participants-podium">
        <?php
        foreach ($topTrois as $position => $user) {
            echo "<div class='participants-card participants-card-$position'>";
                echo "<p class='participants-rank-number'>".($position + 1)."</p>";
                echo "<img src='".$user['profil_picture']."' alt='avatar'>";
                echo "<p>".$user['username']."</p>";
                echo "<p class='participants-points'>".$user['points']." pts</p>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="participants-global">
    <p class="participants-badge">Classement global</p>

    <div class="participants-filters">
        <input type="text" id="search-input" placeholder="Rechercher un participant…">
        <button type="button" id="btn-reset">Reset</button>
    </div>

    <div class="participants-list" id="participants-list">
        <?php
        if (count($tousLesUtilisateurs) == 0) {
            echo "<p>Aucun résultat.</p>";
        }
        foreach ($tousLesUtilisateurs as $index => $user) {
            $statut = $user['points'] > 0 ? 'actif' : 'inactif';
            $rang = $index + 1;
            echo "<div class='participants-row'>";
                echo "<img src='".$user['profil_picture']."' alt='avatar'>";
                echo "<p class='row-rank'>#".$rang."</p>";
                echo "<p class='row-name'>".$user['username']."</p>";
                echo "<p>".$statut."</p>";
                echo "<p class='row-points'>".$user['points']." pts</p>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="participants-pagination" id="participants-pagination"></div>
</div>

<script src="./scripts/participants.js"></script>