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

    if ($first_name === '') $errors[] = "Le prénom est requis.";
    if ($last_name === '') $errors[] = "Le nom est requis.";
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $errors[] = "Adresse email invalide.";
    if (!preg_match('/^[0-9]{10}$/', $phone_clean)) $errors[] = "Numéro de téléphone invalide.";
    if ($role !== 'Admin' && $role !== 'Membre') $role = 'Membre';

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

<div class="background-presentation">

    <h1>Gestion des membres</h1>

    <?php if ($success): ?>
        <p class="gestion-droit-success"><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="gestion-droit-errors">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="gestion-droit-membres">
        <div class="gestion-droit-head gestion-droit-row">
            <p>ID</p>
            <p>Utilisateur</p>
            <p>Prénom</p>
            <p>Nom</p>
            <p>Email</p>
            <p>Téléphone</p>
            <p>Rôle</p>
            <p>Action</p>
        </div>
        <?php foreach ($users as $user): ?>
            <div class="gestion-droit-membre gestion-droit-row">
                <p><?php echo $user['id']; ?></p>
                <p><?php echo $user['username']; ?></p>
                <p><?php echo $user['first_name']; ?></p>
                <p><?php echo $user['last_name']; ?></p>
                <p><?php echo $user['email_address']; ?></p>
                <p><?php echo $user['phone']; ?></p>
                <p><?php echo $user['role']; ?></p>
                <p><a href="?page=gestion_droit&edit_user=<?php echo $user['id']; ?>">Modifier</a></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($editUser): ?>
        <h2>Modifier les informations de <?php echo $editUser['username']; ?></h2>
        <form method="post" action="?page=gestion_droit&edit_user=<?php echo $editUser['id']; ?>" class="gestion-droit-form">
            <input type="hidden" name="edit_user_id" value="<?php echo $editUser['id']; ?>">
            <div>
                <label>Nom d'utilisateur :</label>
                <span><?php echo $editUser['username']; ?></span>
            </div>
            <div>
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $editUser['first_name']; ?>">
            </div>
            <div>
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $editUser['last_name']; ?>">
            </div>
            <div>
                <label for="email_address">Email :</label>
                <input type="email" id="email_address" name="email_address" value="<?php echo $editUser['email_address']; ?>">
            </div>
            <div>
                <label for="phone">Téléphone :</label>
                <input type="text" id="phone" name="phone" value="<?php echo $editUser['phone']; ?>">
            </div>
            <div>
                <label for="role">Rôle :</label>
                <select id="role" name="role">
                    <option value="Membre" <?php echo $editUser['role'] === 'Membre' ? 'selected' : ''; ?>>Membre</option>
                    <option value="Admin" <?php echo $editUser['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div>
                <button type="submit">Sauvegarder</button>
            </div>
        </form>
    <?php endif; ?>

</div>