<?php
role();
?>

<div class="login-presentation">

<h1>Tableau de bord : Newsletter</h1>

<?php
$stmt = $pdo->prepare("SELECT email_address, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="newsletter-all">
    <div class="newsletter-form-section">
        <h2>Envoyer une newsletter :</h2>
        <form action="?page=newsletter" method="post">
            <div class="mb-3">
                <label for="sujet">Sujet du mail :</label>
                <input type="text" name="sujet" id="sujet" placeholder="Ex: Nouvelle mise à jour..." required>
            </div>
            <div class="mb-3">
                <label for="contenu">Message :</label>
                <textarea name="contenu" id="contenu" rows="8" placeholder="Écrivez votre message ici..." required></textarea>
            </div>
            <button type="submit" name="submit_newsletter" class="btn-valider">Envoyer à tous</button>
        </form>
    </div>

    <div class="newsletter-destinataires">
        <h2>Destinataires (<?php echo count($users); ?> utilisateurs)</h2>
        <ul>
            <?php foreach ($users as $user) {
                echo "<li>".$user['username']." | ".$user['email_address']."</li>";
            } ?>
        </ul>
    </div>

</div>

<?php
if (isset($_POST['submit_newsletter'])) {
    $sujet = $_POST['sujet'];
    $contenu = $_POST['contenu'];

    foreach ($users as $user) {
        $email = $user['email_address'];
        //Envoie mail $email avec $sujet $contenu
    }
    $total = count($users);
    sendLog("Newsletter - $sujet (à $total utilisateurs)");
        
    echo "<div class='success'>";
    echo "<p>Newsletter envoyée !</p>";
    echo "</div>";
}
?>

</div>