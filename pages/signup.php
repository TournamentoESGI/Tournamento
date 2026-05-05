<div class="signup-presentation">
    <div class="signup-carte">
        <div class="signup-carte-titre">
            <h2>Inscription :</h2>
        </div>
        <div class="signup-form">
            <h2>Sign Up </h2>
            <form action="?page=signup" method="post">
                <div class="mb-3">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" name="username" placeholder="Ex. CaporalTacos..." required>
                </div>

                <div class="mb-3">
                    <label for="first_name">Prénom :</label>
                    <input type="text" name="first_name" placeholder="Ex. Julia..." required>
                </div>

                <div class="mb-3">
                    <label for="last_name">Nom :</label>
                    <input type="text" name="last_name" placeholder="Ex. DUPONT..." required>
                </div>

                <div class="mb-3">
                    <label for="email_address">Email :</label>
                    <input type="email" name="email_address" placeholder="Ex. adress@gmail.com..." required>
                </div>

                <div class="mb-3">
                    <label for="date_of_birth">Date de naissance</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                </div>

                <div class="mb-3">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="tel" id="phone" name="phone" minlength="10" maxlength="10" placeholder="Ex. +33 7 68 65.." required>
                </div>
                
                <div class="mb-3">
                    <label for="password">Mot de Passe :</label>
                    <input type="password" name="password" minlength="8" placeholder="Password.." required>
                </div>

                <div class="mb-3">
                    <label for="passwordverify">Vérification Mot de Passe :</label>
                    <input type="password" name="passwordverify" minlength="8" placeholder="Verify Password.." required>
                </div>


                <div class="signup-actions">
                    <label for="termconditions">
                        <input type="checkbox" name="termconditions" id="termconditions">
                        Accepter les termes et conditions
                    </label>
                    <button type="submit" name="submit" class="btn-signup">Sign Up</button>
                </div>

            </form>
        </div>
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

    <div class="signup-texte">
        <h1>Bienvenue!<br>Organiser, Participer, Parier : Vous y retrouverez votre compte </h1>
        <p>Tournamento est la plateforme idéale pour organiser et regarder des tournois !
             Si vous êtes embitieux et souhaitez participer à un tournoi pour gagner de l'argent,
              n'hésitez pas et sautez dans l'arène ! 
        </p>
        <img src="assets/second_logo.png" alt="Logo" class="second-logo">
    </div>
</div>


<?php
try {

$counterror=0;

if (isset($_POST['submit'])) {

    $username= $_POST['username'];
    $first_name= $_POST['first_name'];
    $last_name= $_POST['last_name'];
    $email_address= $_POST['email_address'];
    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
    $date_of_birth= $_POST['date_of_birth'];
    $numBrute= $_POST['phone'];
    echo "<div class='erreurs'>";
    if (str_starts_with ($numBrute, '+') ||
        str_starts_with ($numBrute, '+33') || 
        str_starts_with ($numBrute, '33')) {
            echo '<p>Veuillez suivre ce format Ex: 07 08 67 65 42</p>';
            $counterror+=1;
    }
    $numNumeric=str_replace(['+', ' '], '', $numBrute);

    if (strlen($_POST['password']) < 8) {
    echo "<p>Le mot de passe doit faire au moins 8 caractères.</p>";
    $counterror += 1;

    } if ($_POST['password']!= $_POST['passwordverify']) {
        echo "<p>Les mots de passe ne correspondent pas. </p>";
        $counterror+=1;

    } if (!strpos ($email_address , '@')) {
        echo "<p> Pas un email valide. </p>";
        $counterror+=1;

    } if (!is_numeric($numNumeric)){
        echo "<p>Numéro de téléphone contenant uniquement des chiffres.</p>";
        $counterror+=1;

    } if ($counterror==0) {

        $sql= "SELECT * FROM users WHERE username = '$username' OR email_address = '$email_address'";

        $stmt= $pdo->query($sql);
        $result= $stmt->fetchAll();
        if (count($result) > 0) {
            echo "<p>Nom d'utilisateur ou email déjà utilisé. </p>";
            echo "</div>";
        }  else {
            $sql = "INSERT INTO users (username, first_name, last_name, email_address, password, date_of_birth, phone)
                    VALUES ('$username', '$first_name', '$last_name', '$email_address', '$password', '$date_of_birth', '$numNumeric')";
            $pdo->query($sql);
            echo "Compte créé avec succès !";
        }
    }
}

} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
