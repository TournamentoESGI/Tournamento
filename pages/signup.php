<section class = "signup-form">
    <h2>Sign Up </h2>
    <form action="?page=signup" method="post">

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" placeholder="Ex. CaporalTacos..." required>

        <label for="first_name">Prénom :</label>
        <input type="text" name="first_name" placeholder="Ex. Julia..." required>

        <label for="last_name">Nom :</label>
        <input type="text" name="last_name" placeholder="Ex. DUPONT..." required>

        <label for="email_address">Email :</label>
        <input type="text" name="email_address" placeholder="Ex. adress@gmail.com..." required>

        <label for="password">Mot de Passe :</label>
        <input type="password" name="password" placeholder="Password.." required>

        <label for="passwordverify">Vérification Mot de Passe :</label>
        <input type="password" name="passwordverify" placeholder="Verify Password.." required>

        <label for="date_of_birth">Date de naissance</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>
           
        <label for="phone">Numéro de téléphone</label>
        <input type="tel" id="phone" name="phone" placeholder="Ex. +33 7 68 65.." required>

        <button type="submit" name="submit"> Sign Up </button>
    </form>
</section>

<?php
try {

if (isset($_POST['submit'])) {

    $username= $_POST['username'];
    $first_name= $_POST['first_name'];
    $last_name= $_POST['last_name'];
    $email_address= $_POST['email_address'];
    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
    $date_of_birth= $_POST['date_of_birth'];
    $phone= $_POST['phone'];

    if ($_POST['password']!= $_POST['passwordverify']) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        
        $sql = "SELECT * FROM users WHERE username = '$username' OR email_address = '$email_address'";

        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            echo "Nom d'utilisateur ou email déjà utilisé.";
        }  else {
            $sql = "INSERT INTO users (username, first_name, last_name, email_address, password, date_of_birth, phone)
                    VALUES ('$username', '$first_name', '$last_name', '$email_address', '$password', '$date_of_birth', '$phone')";
            $pdo->query($sql);
            echo "Compte créé avec succès !";
        }
    }
}

} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
