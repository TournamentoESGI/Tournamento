<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$pageCourante = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$parPage = 50;

$stats = $pdo->query("
    SELECT
        (SELECT COUNT(id) FROM users) AS  totalUsers,
        (SELECT COUNT(id) FROM participants) AS totalParticipants,
        (SELECT COUNT(id)FROM tournaments) AS totalTournaments
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

$listeFiltrer = [];
foreach ($tousLesUtilisateurs as $user) {
    if ($search == ''|| strpos($user['username'],  $search) !== false) {
        $listeFiltrer[] = $user;
    } 

}

$nbPages = (int)ceil(count($listeFiltrer) / $parPage);
$nbPages = max(1, $nbPages);
$pageCourante = max(1, min($pageCourante, $nbPages));
 
$debut  = ($pageCourante - 1) *$parPage;
$utilisateursDeLaPage= array_slice($listeFiltrer, $debut, $parPage);
?>
 
<div class="participants-banner">
    <p class="participants-tag">Communauté</p>
    <h1>Les meilleurs Participants,</h1>
    <h2>Le top des guerriers de Tournamento</h2>
    <p>Voici le classement mensuel de nos meilleurs combattants.  Gagner et participer à des tournois vous fait gagner des points.</p>

    <div class="participants-stats">
        <div><p><?php echo $stats['totalUsers']; ?></p><p>Utilisateurs</p></div>
        <div><p><?php echo $stats['totalParticipants']; ?></p><p>Participations</p></div>
        <div><p><?php echo $stats['totalTournaments']; ?></p><p>Tournois joués</p></div>
    </div>
</div>
 
<div class="participants-top">
    <p class="participants-badge">Classement - Les meilleurs joueurs du mois !</p>

    <div class="participants-podium" >
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
 
    <form method="GET" class="participants-filters">
        <input type="hidden" name="page" value="participants">
        <input type="hidden" name="p" value="1">
        <input type="text" name="search" placeholder="Rechercher un participant…" value="<?php echo $search; ?>">

        <button type="submit">Filtrer</button>
        <button type="button" onclick="location.href='?page=participants'">Reset</button>
    </form>
 
    <div class="participants-list">
        <?php
        if (count($utilisateursDeLaPage) == 0) {
            echo "<p>Aucun résultat.</p>";
        }
        foreach ($utilisateursDeLaPage as $index => $user) {
            $statut= $user['points'] > 0 ? 'actif' :'inactif';
            $rang  = $debut+ $index + 1;
            echo "<div class='participants-row'>";
                echo"<img src='".$user['profil_picture']."' alt='avatar'>";
                echo "<p class='row-rank'>#".$rang."</p>";
                echo"<p class='row-name'>".$user['username']."</p>";

                echo "<p>".$statut."</p>";
                echo"<p class='row-points'>".$user['points']." pts</p>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="participants-pagination">
        <?php
        for ($n = 1; $n <= $nbPages; $n++) {
            if ($n == 1 || $n == $nbPages || ($n >= $pageCourante - 2 && $n <= $pageCourante + 2)) {
                $classe = $n == $pageCourante ? 'active' : '';
                echo "<a href='?page=participants&p=$n&search=$search' class='$classe'>$n</a>";
            } elseif ($n == $pageCourante - 3 || $n == $pageCourante + 3) {
                echo "<a>...</a>";
            }
        }
        ?>
    </div>
</div>