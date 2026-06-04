<?php
verifieRoleAdmin();

$stmt = $pdo->prepare("SELECT email_address, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
$total = count($users);

if (isset($_POST['submit_newsletter'])) {
    $sujet = $_POST['sujet'];
    $contenu = $_POST['contenu'];
    $author = $_SESSION['username'];

    foreach ($users as $user) {
        SendMail($user['email_address'], $sujet, $contenu);
    }

    $stmt = $pdo->prepare("INSERT INTO newsletter (author, sujet, contenu) VALUES (?, ?, ?)");
    $stmt->execute([$author, $sujet, $contenu]);

    header("Location: ?page=newsletter&success=1");
    exit();
}

$liste = "";
foreach (array_slice($users, 0, 10) as $user) {
    $liste .= "<li>" . $user['username'] . " | " . $user['email_address'] . "</li>";
}
if ($total > 10) {
    $liste .= "<li class='more'>... et " . ($total - 10) . " autres</li>";
}
?>

<div class="login-presentation">
    <div class="newsletter-nav">
        <a href="?page=newsletter" class="nav-link <?= ($_GET['page'] == 'newsletter') ? 'active' : '' ?>">Envoie</a>
        <a href="?page=newsletter_historique" class="nav-link <?= ($_GET['page'] == 'newsletter_historique') ? 'active' : '' ?>">Historique</a>
    </div>
    <h1>Tableau de bord : Newsletter</h1>

    <?php if (isset($_GET['success'])) { echo "<div class='success'><p>Newsletter envoyée !</p></div>"; } ?>

    <div class="newsletter-all">
        <div class="newsletter-form-section">
            <h2>Envoyer une newsletter :</h2>
            <form action="?page=newsletter" method="post" id="newsletter-form">
                <div class="mb-3">
                    <label for="sujet">Sujet du mail :</label>
                    <input type="text" name="sujet" id="sujet" placeholder="Ex: Nouvelle mise à jour..." required readonly>
                </div>
                <div class="mb-3">
                    <label for="contenu">Message :</label>
                    <textarea name="contenu" id="contenu" rows="8" placeholder="Écrivez votre message ici..." required readonly></textarea>
                </div>
                <button type="button" id="btn-edit-save" class="btn-modifier" onclick="toggleEditMode()">Modifier</button>
                <button type="submit" name="submit_newsletter" id="btn-send" class="btn-envoyer" disabled>Envoyer</button>
            </form>
        </div>

        <div class="newsletter-destinataires">
            <h2>Destinataires (<?= $total ?> utilisateurs)</h2>
            <ul><?= $liste ?></ul>
        </div>
    </div>
</div>
<script src="./scripts/newsletter.js"></script>