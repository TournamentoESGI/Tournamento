<?php
verifieRoleAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['user_id']) && !empty($_POST['motif'])) {

        $user_id = (int) $_POST['user_id'];
        $motif = trim($_POST['motif']);

        $stmt = $pdo->prepare("INSERT INTO banned (user_id, motif) VALUES (?, ?)");
        $stmt->execute([$user_id, $motif]);

        $stmt = $pdo->prepare("UPDATE users SET is_banned = 1 WHERE id = ?");
        $stmt->execute([$user_id]);
    }
}

$stmt = $pdo->query("SELECT users.id, users.username, users.first_name, users.last_name, banned.motif, banned.ban_date FROM users JOIN banned ON banned.user_id = users.id WHERE users.is_banned = 1;");
$bannedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT id, username FROM users WHERE is_banned = 0");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Bannir un membre</h2>

<form method="POST">
    <label>Membre :</label>
    <select name="user_id" required>
        <?php foreach ($users as $u): ?>
            <option value="<?= $u['id'] ?>"><?= $u['username'] ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>Motif :</label>
    <textarea name="motif" required></textarea>

    <br><br>

    <button type="submit">Bannir</button>
</form>

<h2>Liste des membres bannis</h2>

<?php if (empty($bannedUsers)): ?>

<p>Aucun membre banni.</p>

<?php else: ?>

<table>
    <tr>
        <td><b>Username</b></td>
        <td><b>Nom</b></td>
        <td><b>Prénom</b></td>
        <td><b>Motif</b></td>
        <td><b>Date</b></td>
        <td><b>Action</b></td>
    </tr>

    <?php foreach ($bannedUsers as $user): ?>
    <tr>
        <td><?= $user['username'] ?></td>
        <td><?= $user['last_name'] ?></td>
        <td><?= $user['first_name'] ?></td>
        <td><?= $user['motif'] ?></td>
        <td><?= $user['ban_date'] ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="unban_id" value="<?= $user['id'] ?>">
                <button type="submit">Débannir</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php 
if (isset($_POST['unban_id'])) {
    $id = (int) $_POST['unban_id'];

    $stmt = $pdo->prepare("UPDATE users SET is_banned = 0 WHERE id = ?");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("DELETE FROM banned WHERE user_id = ?");
    $stmt->execute([$id]);
}
endif;
?>