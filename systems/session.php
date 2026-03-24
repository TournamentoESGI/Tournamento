<?php
if (!isset($_SESSION['user']) && isset($_COOKIE['remember'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
    $stmt->execute([$_COOKIE['remember']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
    }
}
?>
