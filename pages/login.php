<?php
    session_start();
    require_once './systems/config.php';
?>
<div>
    <img src="assets/background.png" alt="background">
    <div>
        <h1>Bon retour,<br>Prêt à parier ?</h1>
        <div></div>
        <p>Tournamento est la plateforme idéale pour organiser et regarder des tournois !
             Si vous êtes embitieux et souhaitez participer à un tournoi pour gagner de l’argent,
              n’hésitez pas et sautez dans l’arène ! 
        </p>
    </div>
    <div>
        <img src="assets/second_logo.png" alt="Logo">
    </div>
    <div>
        <div>
            <img src="" alt="">
            <h2></h2>
        </div>
        <form action="" method="post">
            <div>
                <label for="username"></label>
                <input type="text" name="username" id="username" placeholder="nom d'utilisateur">
            </div>
            <div>
                <label for="password"></label>
                <input type="password" name="password" id="password" placeholder="mot de passe">
            </div>
            <div>
                <label class="checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <span class="checkmark"></span>
                    <p>Rester connecté</p>
                </label>
                <?php
                if (isset($_POST['remember'])) {
                    $token = bin2hex(random_bytes(32));

                    $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $stmt->execute([$token, $user['id']]);

                    setcookie(
                        "remember",
                        $token,
                        time() + (86400 * 10),
                        "/",
                        "",
                        true,
                        true
                    );
                }
                ?>
            </div>
            <button type="submit">Valider</button>
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

        <div>
            <div></div>
            <p>ou</p>
            <div></div>
        </div>
        <button>
            <img src="" alt="">
            <p>Se connecter avec Apple</p>
        </button>
    </div>
</div>