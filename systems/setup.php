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

CREATE TABLE IF NOT EXISTS tournaments (
    id_tournaments INT AUTO_INCREMENT PRIMARY KEY,
    tournament_name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    discipline VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    entry_fee NUMBER(10) NOT NULL,
    max_users INT NOT NULL,
    cash_prize NUMBER(10) NOT NULL,
    bet_status ENUM('open', 'closed') NOT NULL DEFAULT 'open',
    status ENUM('started', 'upcoming', 'completed') NOT NULL DEFAULT 'upcoming',
    img DEFAULT 'default_tournament_image.jpg'
);

CREATE TABLE IF NOT EXISTS bets (
    id_bets INT AUTO_INCREMENT PRIMARY KEY,
    id_users INT NOT NULL,
    id_tournaments INT NOT NULL,
    stake_amount NUMBER(10) NOT NULL,
    potential_win NUMBER(10) NOT NULL,
    status ENUM('pending', 'won', 'lost') NOT NULL DEFAULT 'pending',
    bet_target VARCHAR(255) NOT NULL,
    bet_date DATE DEFAULT CURRENT_DATE,
    FOREING KEY id_users REFERENCE users(id_users),
    FOREING KEY id_tournaments REFERENCE tournaments(id_tournaments)
);

";

$pdo->exec($sql);
?>
