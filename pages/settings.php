<?php
verifieCompteConnecte();
$id = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT username, email_address, phone, password FROM users WHERE id = ?");
$stmt->execute([$id]);
$results = $stmt->fetch();

$old_email = $results['email_address'];
$old_password = $results['password'];
$old_phone = $results['phone'];
?>

<div class="settings-presentation">

    <div class="settings-container">
        <div class="settings-header">
            <h1>Modifier les informations personnelles</h1>
            <a href="?page=profil" class="btn-retour"> Retour au profil</a>
        </div>
        <p><?php echo "Bonjour " . $_SESSION['username'] . " ! Ici tu modifies des informations
        importantes qui nécessitent une confirmation via mot de passe, alors fais bien attention."; ?></p>

        <form action="" method="post">

            <div class="settings-ligne">
                <label for="email">Adresse E-mail</label>
                <input type="email" id="email" name="email_address" value="<?php echo $old_email; ?>">
            </div>

            <div class="settings-ligne">
                <label for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $old_phone; ?>">
            </div>

            <div class="settings-ligne">
                <label for="password">Changement Mot de passe</label>
                <input type="password" id="password" name="password" minlength="8" placeholder="Ex. 1éez349!d:z39" >
            </div>

            <div class="settings-ligne">
                <label for="conf_password">Confirmer Ancien Mot de passe</label>
                <input type="password" id="conf_password" name="conf_password" minlength="8" placeholder="Ex. 1éez349!d:z39" required>
            </div>

            <button type="submit" name="submit">Sauvegarder</button>

        </form>

<?php
if(isset($_POST['submit'])) {

    $new_email = $_POST['email_address'];
    $new_phone = $_POST['phone'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf_password'];

    $new_phone_clean = str_replace(' ', '', $new_phone);
    $old_phone_clean = str_replace(' ', '', $old_phone);

    $count_error = 0;
        
    echo "<div class='erreurs'>";

       if (!empty($password) && !empty($conf_password)) {

            if (strlen($password) < 8) {
                echo "<p>8 caractères minimum</p>";
                $count_error++;
            }

            if (!password_verify($conf_password, $old_password)) {
                echo "<p>Ancien mot de passe incorrect</p>";
                $count_error++;
            }

            if (password_verify($password, $old_password)) {
                echo "<p>Nouveau mot de passe identique à l'ancien</p>";
                $count_error++;
            }
        }
            
        if(!isPhoneValid($new_phone_clean)) {
            echo "<p>Numéro de téléphone invalide.</p>";
            $count_error++;
        }
        if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Email invalide.</p>";
            $count_error++;
        }


    echo "</div>";
    if($count_error === 0) {
        if($new_phone_clean !== $old_phone_clean) {
            $stmt = $pdo->prepare("UPDATE users SET phone = ? WHERE id = ?");
            $stmt->execute([$new_phone_clean, $id]);
        }

        if($new_email !== $old_email) {
            $stmt = $pdo->prepare("UPDATE users SET email_address = ? WHERE id = ?");
            $stmt->execute([$new_email, $id]);
        }

        if (!empty($password)) {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$password_hash, $id]);
        }

        echo "<div class='success'><p>Modifications enregistrées !</p></div>";
    }
}
?>
    </div>
</div>