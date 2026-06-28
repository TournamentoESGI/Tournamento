<?php

createTable("
users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    profil_picture VARCHAR(255) DEFAULT './assets/profil_picture/default_profile_picture.png',
    role VARCHAR(10) DEFAULT 'Membre',
    current_balance INT DEFAULT 0,
    last_activity DATETIME DEFAULT CURRENT_TIMESTAMP,
    force_logout TINYINT(1) DEFAULT 0,
    inactive_mail_sent TINYINT(1) DEFAULT 0,
    is_verified TINYINT(1) NOT NULL DEFAULT 0
)
");

createTable("
banned (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ban_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    motif VARCHAR(255) NOT NULL
)
");

createTable("
tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author INT,
    title VARCHAR(50),
    description VARCHAR(255) DEFAULT '',
    status ENUM('edit','open','closed') DEFAULT 'edit',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    start_date DATE,
    end_date DATE
)
");

createTable("
pools (
	id INT AUTO_INCREMENT PRIMARY KEY,
	number INT,
	tournament INT,
	title VARCHAR(50) DEFAULT 'New pool',
	posX INT DEFAULT 0,
	posY INT DEFAULT 0,
    id_vainqueur INT DEFAULT NULL
)
");

createTable("
participants (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user INT NOT NULL,
	pool INT,
	tournament INT,
	nickname VARCHAR(20),
	winner TINYINT DEFAULT 0,
    position INT DEFAULT NULL
)
");

createTable("
paris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_participant INT NOT NULL,
    id_parieur INT NOT NULL,
    somme INT NOT NULL,
    status ENUM('en cours', 'gagner', 'perdu', 'fermer'),
    date DATETIME DEFAULT CURRENT_TIMESTAMP
)
");

createTable("
captchas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img_url VARCHAR(50),
    splits INT
)
");

createTable("
logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255),
    author VARCHAR(255),
    tag VARCHAR(32),
    date DATETIME,
    page VARCHAR(63) DEFAULT ''
)
");

createTable("
email_verification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(65) NOT NULL,
    expires_at DATETIME NOT NULL
)
");

createTable("
newsletter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author VARCHAR(255),
    sujet VARCHAR(255),
    contenu TEXT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP
)
");

createTable("
auto_mails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    frequency ENUM('daily','weekly','monthly') NOT NULL,
    last_sent DATETIME DEFAULT NULL
)
");

?>
