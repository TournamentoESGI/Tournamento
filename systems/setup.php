<?php
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    username VARCHAR(15),
    email VARCHAR(255),
    password VARCHAR(255), /* Mis à 255 au cas où tu haches tes mots de passe avec bcrypt/argon2 */
    role VARCHAR(10),
    telephone CHAR(10),
    date_naissance DATE,
    creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

$pdo->exec($sql);
?>
