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

<h1>Membres en ligne actuellement</h1>

<?= $message ?>

<div>
    <div>
        <span>Utilisateur</span>
        <span>Action</span>
    </div>

    <?php if (count($onlineUsers) > 0): ?>
        <?php foreach ($onlineUsers as $user): ?>
            <div>
                <span><?= htmlspecialchars($user['username']) ?></span>
                <span>
                    <a href="?page=online&disconnect_user=<?= $user['id'] ?>" onclick="return confirm('Déconnecter cet utilisateur ?');">Déconnecter</a>
                </span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun membre n'est en ligne.</p>
    <?php endif; ?>
</div>