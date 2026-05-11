<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT username, email_address, phone FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur introuvable.");
}

$errors = [];
$success = "";

if (isset($_POST['submit'])) {

    $email = trim($_POST['email_address']);
    $phone = trim($_POST['phone']);

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide.";
    }

    if (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Le numéro de téléphone doit contenir 10 chiffres.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET email_address = ?, phone = ? WHERE id = ?");
        $stmt->execute([$email, $phone, $id]);

        $success = "Informations mises à jour avec succès.";

        $user['email_address'] = $email;
        $user['phone'] = $phone;
    }
}
?>

<div>
    <h1>Modifier les informations personnelles</h1>

    <div>
        <h2>Nom d'utilisateur</h2>
        <p><?= htmlspecialchars($user['username']) ?></p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-box">
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="email">Adresse E-mail</label>
                <input type="email" name="email_address" class="from-control"
                       placeholder="monadressemail@mail.com"
                       value="<?= htmlspecialchars($user['email_address']) ?>">
            </div>

            <div class="mb-3">
                <label for="phone">Téléphone</label>
                <input type="tel" name="phone" minlength="10" maxlength="10" class="from-control"
                       placeholder="Ex. 0768654210"
                       value="<?= htmlspecialchars($user['phone']) ?>">
            </div>

            <button type="submit" name="submit" class="btn-save">Sauvegarder</button>
        </form>
    </div>
</div>