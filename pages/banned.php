<?php
verifieRoleAdmin();
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['unban_id'])) {
        $id = (int) $_POST['unban_id'];
        $stmt = $pdo->prepare("DELETE FROM banned WHERE user_id = ?");
        $stmt->execute([$id]);
        $success = "Utilisateur débanni.";
    }

    if (!empty($_POST['user_id']) && !empty($_POST['motif'])) {
        $user_id = (int) $_POST['user_id'];
        $motif = trim($_POST['motif']);

        $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = "Utilisateur introuvable.";
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(id) FROM banned WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $count = (int)$stmt->fetchColumn();

            if ($count > 0) {
                $error = "Cet utilisateur est déjà banni.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO banned (user_id, motif) VALUES (?, ?)");
                $stmt->execute([$user_id, $motif]);
                $success = "Utilisateur banni.";
            }
        }
    }
}

$stmt = $pdo->prepare("SELECT u.id, u.username, u.first_name, u.last_name, b.motif, b.ban_date FROM users u JOIN banned b ON b.user_id = u.id");
$stmt->execute();
$bannedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id NOT IN (SELECT user_id FROM banned)");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="background-presentation">

    <h1>Gestion des bans</h1>

    <div class="ban-all">

        <div class="ban-form-section">
            <h2>Bannir un membre</h2>

            <?php if ($error): ?>
                <div class="erreurs"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><p><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p></div>
            <?php endif; ?>

            <form method="POST">
                <label>Membre :</label>
                <select name="user_id" required>
                    <?php foreach ($users as $u): ?>
                        <option value="<?php echo (int)$u['id']; ?>"><?php echo htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>

                <br><br>

                <label>Motif :</label>
                <textarea name="motif" required></textarea>

                <br><br>

                <button type="submit" class="btn-bannir">Bannir</button>
            </form>
        </div>

        <div class="ban-liste">
            <h2>Membres bannis</h2>

            <?php if (empty($bannedUsers)): ?>
                <p>Aucun membre banni.</p>
            <?php else: ?>
                <div class="ban-head ban-row">
                    <p>Username</p>
                    <p>Nom</p>
                    <p>Prénom</p>
                    <p>Motif</p>
                    <p>Date</p>
                    <p>Action</p>
                </div>
                <?php foreach ($bannedUsers as $user): ?>
                    <div class="ban-membre ban-row">
                        <p><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><?php echo htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><?php echo htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><?php echo htmlspecialchars($user['motif'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><?php echo htmlspecialchars($user['ban_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p>
                            <form method="POST">
                                <input type="hidden" name="unban_id" value="<?php echo (int)$user['id']; ?>">
                                <button type="submit" class="btn-debannir">Débannir</button>
                            </form>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

</div>