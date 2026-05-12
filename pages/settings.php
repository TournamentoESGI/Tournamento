<?php
if (!isset($_SESSION['username'])) {
    echo "Utilisateur non connecté";
    exit;
}

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT email_address, phone, password FROM users WHERE username = ?");
$stmt->execute([$username]);
$results = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$results) {
    echo "Utilisateur introuvable";
    exit;
}

$old_email = $results['email_address'];
$old_password = $results['password'];
$old_phone = $results['phone'];

?>

<div class="container mt-4">
    <div class="row justify-content-center">

        <h1>Modifier les informations personnelles</h1>
        <p>Hey <?php echo $username;?></p>

        <div class="col-md-6">
            <form action="" method="post" class="p-4 border rounded bg-light">

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse E-mail</label>
                    <input type="email" id="email" name="email_address" class="form-control" value="<?php echo $old_email; ?>">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Téléphone</label>
                    <input type="tel" id="phone" name="phone" minlength="10" maxlength="10" class="form-control" value="<?php echo $old_phone; ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" minlength="8" class="form-control" placeholder="Ex. 1éez349!d:z39">
                </div>

                <div class="mb-3">
                    <label for="conf_password" class="form-label">Confirmer Mot de passe</label>
                    <input type="password" id="conf_password" name="conf_password" minlength="8" class="form-control" placeholder="Ex. 1éez349!d:z39">
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">Sauvegarder</button>

            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    try {
        $new_email = $_POST['email_address'];
        $new_phone = $_POST['phone'];
        $password = $_POST['password'];
        $conf_password = $_POST['conf_password'];

        $errors = [];
        
        if (!empty($password)) {
            if (strlen($password) < 8) {
                $errors[] = "Le mot de passe doit faire au moins 8 caractères";
            }
            if ($password !== $conf_password) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }
            if (password_verify($password, $old_password)) {
                $errors[] = "Le nouveau mot de passe ne doit pas être identique à l'ancien";
            }
        }

        if (strlen($new_phone) !== 10) {
            $errors[] = "Numéro de téléphone invalide";
        }

        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        }

        if (empty($errors)) {
            if ($new_phone !== $old_phone) {
                $stmt = $pdo->prepare("UPDATE users SET phone = ? WHERE username = ?");
                $stmt->execute([$new_phone, $username]);
            }

            if ($new_email !== $old_email) {
                $stmt = $pdo->prepare("UPDATE users SET email_address = ? WHERE username = ?");
                $stmt->execute([$new_email, $username]);
            }

             if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->execute([$password_hash, $username]);
            }

            echo "Modifications enregistrées";
        } else {
            foreach ($errors as $e) {
                echo "<p style='color:red'>$e</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Erreur : " . $e->getMessage() . "</p>";
    }
}


?>