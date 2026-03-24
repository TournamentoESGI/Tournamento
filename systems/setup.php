<?php
function createTable($table) {
    global $pdo;
    $query = "CREATE TABLE IF NOT EXISTS ".$table.";";
    $pdo->exec($query);
}

createTable("
users (
    id_users INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    phone INT(10) NOT NULL UNIQUE,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    current_balance INT DEFAULT 0,
    creation_date DATE DEFAULT CURRENT_DATE(),
    profil_picture VARCHAR(255) DEFAULT 'default_profile_picture.png'
);
");

createTable("
tournaments (
    id_tournaments INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    description VARCHAR(255),
    games VARCHAR(50),
    status ENUM('ouvert','fermer'),
    created_at DATE DEFAULT CURRENT_DATE(),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL
);
");

createTable("
pools(
    id_pools INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50)
);
");
?>