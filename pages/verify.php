<?php

if (!isset($_GET['token'])) {
    die("Token manquant.");
}

$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT user_id, expires_at FROM email_verification WHERE token = ?");
$stmt->execute([$token]);
$verification = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$verification) {
    die("Lien invalide ou déjà utilisé.");
}

if (strtotime($verification['expires_at']) < time()) {
    $del = $pdo->prepare("DELETE FROM email_verification WHERE token = ?");
    $del->execute([$token]);

    die("Ce lien a expiré. Veuillez demander un nouvel email de vérification.");
}

$update = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE id_users = ?");
$update->execute([$verification['user_id']]);

$del = $pdo->prepare("DELETE FROM email_verification WHERE token = ?");
$del->execute([$token]);

echo "<h1>Votre compte a été vérifié avec succès !</h1>";
echo "<p>Vous pouvez maintenant vous connecter.</p>";
echo "<a href='https://tournamento.ovh/pages/login.php'>Se connecter</a>";


?>