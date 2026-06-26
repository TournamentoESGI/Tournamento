<?php
verifieRoleAdmin();

$message = "";

if (isset($_GET['disconnect_user'])) {
    try {
        $targetId = intval($_GET['disconnect_user']);
        $stmt = $pdo->prepare("UPDATE users SET force_logout = 1 WHERE id = ?");
        $stmt->execute([$targetId]);
        $message = "<p>Utilisateur déconnecté avec succès.</p>";
    } catch (PDOException $e) {
        $message = "<p>Erreur lors de la déconnexion.</p>";
    }
}

try {
    $stmt = $pdo->query("SELECT id, username FROM users WHERE last_activity > DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
    $onlineUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $onlineUsers = [];
}
?>

<div class="background-presentation">

    <h1>Membres en ligne actuellement</h1>

    <?php if ($message): ?>
        <div class="online-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="online-all">
        <div class="online-liste">
            <div class="online-head online-row">
                <p>Utilisateur</p>
                <p>Action</p>
            </div>

            <?php if (count($onlineUsers) > 0): ?>
                <?php foreach ($onlineUsers as $user): ?>
                    <div class="online-membre online-row">
                        <p><?php echo htmlspecialchars($user['username']); ?></p>
                        <p>
                            <a href="?page=online&disconnect_user=<?php echo $user['id']; ?>" class="btn-deconnecter" onclick="return confirm('Déconnecter cet utilisateur ?');">Déconnecter</a>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="padding: var(--medium);">Aucun membre n'est en ligne.</p>
            <?php endif; ?>
        </div>
    </div>

</div>