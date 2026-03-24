<?php
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id_users INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    phone NUMBER(10) NOT NULL UNIQUE,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    current_balance NUMBER DEFAULT 0,
    creation_date DATE DEFAULT CURRENT_DATE,
    profil_picture DEFAULT 'default_profile_picture.jpg'
);

";
$pdo->exec($sql);