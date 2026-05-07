<?php
include_once("./components/captcha.php");
?>

<div class="signup-presentation">
    <div class="signup-carte">
        <div class="signup-carte-titre">
            <h2>Inscription:</h2>
        </div>
        <div class="signup-form">
            <h2>Sign Up </h2>
            <form action="?page=signup" method="post">
                <div class="mb-3">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" name="username" placeholder="Ex. CaporalTacos..." required>
                </div>

                <div class="mb-3">
                    <label for="first_name">Prénom:</label>
                    <input type="text" name="first_name" placeholder="Ex. Julia..." required>
                </div>

                <div class="mb-3">
                    <label for="last_name">Nom:</label>
                    <input type="text" name="last_name" placeholder="Ex. DUPONT..." required>
                </div>

                <div class="mb-3">
                    <label for="email_address">Email:</label>
                    <input type="email" name="email_address" placeholder="Ex. adress@gmail.com..." required>
                </div>

                <div class="mb-3">
                    <label for="date_of_birth">Date de naissance:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" max="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone">Numéro de téléphone:</label>
                    <input type="tel" id="phone" name="phone" minlength="10" maxlength="10" placeholder="Ex. +33 7 68 65.." required>
                </div>
                
                <div class="mb-3">
                    <label for="password">Mot de Passe:</label>
                    <input type="password" name="password" minlength="8" placeholder="Password.." required>
                </div>

                <div class="mb-3">
                    <label for="passwordverify">Vérification Mot de Passe:</label>
                    <input type="password" name="passwordverify" minlength="8" placeholder="Verify Password.." required>
                </div>

                <div class="signup-actions">
                    <label for="termconditions">
                        <input type="checkbox" name="termconditions" id="termconditions" required>
                        Accepter les termes et conditions
                    </label>
                </div>
                
                <div class="captcha-section">
                        <p>CAPTCHA: Veuillez assembler cette image:</p>
                        <?php
                        generateCaptcha($pdo);
                        ?>
                </div>
                <button type="submit" name="submit" class="btn-signup">Sign Up</button>

            </form>
        </div>
    </div>

    <div class="signup-texte">
        <h1>Bienvenue!<br>Organiser, Participer, Parier : Vous y retrouverez votre compte </h1>
        <p>Tournamento est la plateforme idéale pour organiser et regarder des tournois !
             Si vous êtes embitieux et souhaitez participer à un tournoi pour gagner de l'argent,
              n'hésitez pas et sautez dans l'arène ! 
            </p>
            <img src="assets/second_logo.png" alt="Logo" class="second-logo" >

    



<?php
try {

if (isset($_POST['submit'])) {
    
    $username= $_POST['username'];
    $first_name= $_POST['first_name'];
    $last_name= $_POST['last_name'];
    $email_address= $_POST['email_address'];
    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
    $date_of_birth= $_POST['date_of_birth'];
    $num_brute= $_POST['phone'];

        
    $count_error=0;
    $date = DateTime::createFromFormat('Y-m-d', $date_of_birth);
    $today = new DateTime();
    $age = $today->diff($date)->y;

    echo "<div class='erreurs'>";
    if (str_starts_with ($num_brute, '+') ||
        str_starts_with ($num_brute, '+33') || 
        str_starts_with ($num_brute, '33')) {
            echo '<p>Veuillez suivre ce format Ex: 07 08 67 65 42</p>';
            $count_error+=1;
    }
    $num_numeric=str_replace(['+', ' '], '', $num_brute);

    if (strlen($_POST['password']) < 8) {
        echo "<p>Le mot de passe doit faire au moins 8 caractères.</p>";
        $count_error += 1;

    } if ($age < 16) {
        echo "<p>Vous devez avoir au moins 16 ans pour vous inscrire.</p>";
        $count_error += 1;

    } if ($_POST['password']!= $_POST['passwordverify']) {
        echo "<p>Les mots de passe ne correspondent pas. </p>";
        $count_error+=1;

    } if (!strpos ($email_address , '@')) {
        echo "<p> Pas un email valide. </p>";
        $count_error+=1;

    } if (!is_numeric($num_numeric)){
        echo "<p>Numéro de téléphone contenant uniquement des chiffres.</p>";
        $count_error+=1;

    } if (!isset($_POST['termconditions'])) {
        echo "<p>Vous devez accepter les termes et conditions</p>";
        $count_error += 1;

    } if (!isCaptchaValid($_POST['captcha'])) {
    echo "<p> Captcha Invalide </p>";
    $count_error += 1;
    
    }

    $sql= "SELECT * FROM users WHERE username = '$username' OR email_address = '$email_address'";
    $stmt= $pdo->query($sql);
    $result= $stmt->fetchAll();

      if (count($result) > 0) {
        echo "<p>Nom d'utilisateur ou email déjà utilisé. </p>";
        $count_error+=1;

    }

    echo "</div>";
    
    echo "<div class='success'>";

    if ($count_error==0) {
        $sql = "INSERT INTO users (username, first_name, last_name, email_address, password, date_of_birth, phone)
                VALUES ('$username', '$first_name', '$last_name', '$email_address', '$password', '$date_of_birth', '$num_numeric')";
        $pdo->query($sql);
        
        echo "<p>Compte créé avec succès !</p>";
        echo "<script>setTimeout(() => { window.location.replace('?page=login'); }, 2000);</script>";
    }
    echo "</div>";
}

} catch (Exception $ex) {
    displayPageError($ex->getMessage());
}
?>

    </div>
</div>