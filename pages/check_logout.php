<?php

if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("SELECT force_logout FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();

    if ($user && $user['force_logout'] == 1) {
        $stmt = $pdo->prepare("UPDATE users SET force_logout = 0 WHERE id = ?")
        $stmt->execute([$_SESSION['id']]);
        session_destroy();
        
        echo "LOGOUT";
        exit;
    }
}

echo "OK";
exit;
?>