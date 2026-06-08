<div class="support-form-section">
    <h2>Un problème, rempliser ce formulaire :</h2>
    <form action="?page=support" method="post" id="support-form">
        <div class="mb-3">
            <label for="sujet">Sujet de la demande :</label>
            <input type="text" name="sujet" id="sujet" placeholder="Je n'arrive pas à me connecter..." required>
        </div>
        <div class="mb-3">
            <label for="contenu">Message :</label>
            <textarea name="contenu" id="contenu" placeholder="Écrivez votre message ici..." required></textarea>
        </div>
        <div class="mb-3">
            <label for="mail">Adresse Mail :</label>
            <input type="text" name="mail" id="mail" placeholder="monmail@exemple.com" required>
        </div>
        <button type="submit" name="submit_support" id="btn-send" class="btn-envoyer">Envoyer</button>
    </form>
</div>

<?php
if (isset($_POST['submit_support'])) {
    $sujet   = trim($_POST['sujet']);
    $contenu = trim($_POST['contenu']);
    $mail    = trim($_POST['mail']);

    if (empty($sujet) || empty($contenu) || empty($mail)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse mail invalide.";
    } else {
        $message = "
            <h2>Nouvelle demande de support</h2>
            <p><b>De :</b> $mail</p>
            <p><b>Sujet :</b> $sujet</p>
            <p><b>Message :</b><br>$contenu</p>
        ";
        SendMail("noreplytournamento@gmail.com", "Support - $sujet", $message);

        $success = "Votre demande a bien été envoyée.";
    }
}
?>
