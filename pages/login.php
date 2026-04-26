

<div class="login-presentation">
    <div class="login-texte">
        <h1>Bon retour,<br>Prêt à parier ?</h1>
        <p>Tournamento est la plateforme idéale pour organiser et regarder des tournois !
             Si vous êtes embitieux et souhaitez participer à un tournoi pour gagner de l'argent,
              n'hésitez pas et sautez dans l'arène !
        </p>
        <img src="assets/second_logo.png" alt="Logo" class="second-logo">
    </div>

    <div class="login-formulaire">
        <div class="login-carte">
            <div class="login-carte-titre">
                <img src="" alt="">
                <h2>Login Utilisateur :</h2>
            </div>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="nom d'utilisateur">
                </div>
                <div class="mb-3">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="mot de passe">
                </div>
                <div class="mb-3">
                    <label class="checkbox d-flex align-items-center gap-2">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        <p class="mb-0">Rester connecté</p>
                    </label>
                    <?php
                    if (isset($_POST['remember'])) {
                        $token = bin2hex(random_bytes(32));
                        $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                        $stmt->execute([$token, $user['id']]);
                        setcookie("remember", $token, time() + (86400 * 10), "/", "", true, true);
                    }
                    ?>
                </div>
                <button type="submit" name="login" class="btn-valider">Valider</button>
            </form>

            <?php
            if (isset($_POST['login'])) {
                $username = htmlspecialchars(trim($_POST['username']));
                $password = $_POST['password'];
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: profile.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Identifiants ou Mot de passe incorrects.";
                }
            }
            ?>

            <div class="separateur">
                <div></div>
                <p class="mb-0">ou</p>
                <div></div>
            </div>
            <button class="btn-google">
                <img src="" alt="">
                <p class="mb-0">Se connecter avec Google<i class="fa fa-google" aria-hidden="true"></i></p>
            </button>
        </div>
    </div>
</div>