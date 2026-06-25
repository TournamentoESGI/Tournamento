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
                <div class="options">

                    <div class="checkbox_lign">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        <p class="mb-0">Rester connecté</p>
                    </div>

                    <a href="?page=signup" style="color: #bef13a;">S'inscrire</a>
                </div>
                <button type="submit" name="login" class="btn-valider">Valider</button>
            </form>

            <?php
            echo "<div class='erreurs'>";
            if (isset($_POST['login'])) {
                $username = trim($_POST['username']);
                $password = $_POST['password'];
                
                $stmt = $pdo->prepare("SELECT id, password, role, force_logout FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    if ($user['force_logout'] == 1) {
                        $stmt = $pdo->prepare("UPDATE users SET force_logout = 0 WHERE id = ?");
                        $stmt->execute([$user['id']]);
                    }

                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $user['role'];
                    
                    sendLog("Connexion", "user_connect");
                    header("Location: ?page=profil");
                    exit;
                } else {
                    echo "<p>Identifiants ou Mot de passe incorrects</p>";
                }
            }
            echo "</div>";
            ?>
        </div>
    </div>
</div>
