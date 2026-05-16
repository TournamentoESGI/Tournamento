<?php
verifieRoleAdmin();
?>

<div class="presentation">
<div class="newsletter-nav">
    <a href="?page=newsletter" class="nav-link <?= ($_GET['page'] == 'newsletter') ? 'active' : '' ?>">Envoie</a>
    <a href="?page=newsletter_historique" class="nav-link <?= ($_GET['page'] == 'newsletter_historique') ? 'active' : '' ?>">Historique</a>
</div>
<h1>Tableau de bord : Historique Newsletter</h1>

<?php
$sql = "SELECT id, author, sujet, contenu, date FROM newsletter ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();
?>

    <div class="newsletter-historique-container">
        <div class="newsletter-historique-head newsletter-historique-row">
            <p>Log-Id:</p>
            <p>Utilisateur:</p>
            <p>Sujet:</p>
            <p>Contenu:</p>
            <p>Date:</p>
            <p>Heure:</p>
        </div>

<?php
foreach ($results as $newsletter_historique ) {
    echo "<div class='newsletter-historique-item newsletter-historique-row'>";
    echo "<p>".$newsletter_historique ['id']."</p>";
    echo "<p>".$newsletter_historique ['author']."</p>";
    echo "<p>".$newsletter_historique ['sujet']."</p>";
    echo "<p>".$newsletter_historique ['contenu']."</p>";
    echo "<p>".explode(" ",$newsletter_historique ['date'])[0]."</p>";
    echo "<p>".explode(" ",$newsletter_historique ['date'])[1]."</p>";
    echo "</div>";
}
?>

    </div>
</div>
