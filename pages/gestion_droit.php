<?php
verifieRoleAdmin();

$success = "";
$errors = [];
$editUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user_id'])) {
    $editId = intval($_POST['edit_user_id']);
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email_address = trim($_POST['email_address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = trim($_POST['role'] ?? 'Membre');
    $phone_clean = str_replace(' ', '', $phone);

    if ($first_name === '') {
        $errors[] = "Le prénom est requis.";
    }
    if ($last_name === '') {
        $errors[] = "Le nom est requis.";
    }
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }
    if (!preg_match('/^[0-9]{10}$/', $phone_clean)) {
        $errors[] = "Numéro de téléphone invalide.";
    }
    if ($role !== 'Admin' && $role !== 'Membre') {
        $role = 'Membre';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email_address = ?, phone = ?, role = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $email_address, $phone_clean, $role, $editId]);
        $success = "Informations personnelles mises à jour.";
    }

    if ($success || !empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, first_name, last_name, email_address, phone, role FROM users WHERE id = ?");
        $stmt->execute([$editId]);
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (isset($_GET['edit_user'])) {
    $editId = intval($_GET['edit_user']);
    $stmt = $pdo->prepare("SELECT id, username, first_name, last_name, email_address, phone, role FROM users WHERE id = ?");
    $stmt->execute([$editId]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $pdo->prepare("SELECT id, username, first_name, last_name, email_address, phone, role FROM users ORDER BY username ASC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Gestion des membres</h1>

<?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div>
    <div><strong>ID - Nom d'utilisateur - Prénom - Nom - Email - Téléphone - Rôle - Action</strong></div>
    <?php foreach ($users as $user): ?>
        <div>
            <?= $user['id'] ?> - <?= $user['username'] ?> - <?= $user['first_name'] ?> - <?= $user['last_name'] ?> - <?= $user['email_address'] ?> - <?= $user['phone'] ?> - <?= $user['role'] ?> - <a href="?page=gestion_droit&edit_user=<?= $user['id'] ?>">Modifier</a>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($editUser): ?>
    <h2>Modifier les informations de <?= $editUser['username'] ?></h2>
    <form method="post" action="?page=gestion_droit&edit_user=<?= $editUser['id'] ?>">
        <input type="hidden" name="edit_user_id" value="<?= $editUser['id'] ?>">
        <div>
            <label>Nom d'utilisateur :</label>
            <span><?= $editUser['username'] ?></span>
        </div>
        <div>
            <label for="first_name">Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= $editUser['first_name'] ?>">
        </div>
        <div>
            <label for="last_name">Nom :</label>
            <input type="text" id="last_name" name="last_name" value="<?= $editUser['last_name'] ?>">
        </div>
        <div>
            <label for="email_address">Email :</label>
            <input type="email" id="email_address" name="email_address" value="<?= $editUser['email_address'] ?>">
        </div>
        <div>
            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" value="<?= $editUser['phone'] ?>">
        </div>
        <div>
            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="Membre" <?= $editUser['role'] === 'Membre' ? 'selected' : '' ?>>Membre</option>
                <option value="Admin" <?= $editUser['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div>
            <button type="submit">Sauvegarder</button>
        </div>
    </form>
<?php endif; ?>
