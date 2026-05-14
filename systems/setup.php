<?php

$tables = [];

function createTable($new_table) {
    global $tables;
    $table_name = trim(explode("(", $new_table)[0]);
    $query = "CREATE TABLE IF NOT EXISTS " . $new_table . ";";
    $tables[] = ["name" => $table_name, "query" => $query];
}

function deleteDatabase() {
    global $tables, $pdo;
    foreach (array_reverse($tables) as $table) {
        $pdo->exec("DROP TABLE IF EXISTS " . $table["name"] . ";");
    }
}

function makeDatabase() {
    global $tables, $pdo;

    foreach ($tables as $table) {
        $pdo->exec($table["query"]);
    }
}

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
    current_balance INT DEFAULT 0,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    profil_picture VARCHAR(255) DEFAULT './assets/profil_picture/default_profile_picture.png',
    role VARCHAR(10) DEFAULT 'Membre',
    is_verified TINYINT(1) NOT NULL DEFAULT 0
)
");

createTable("
tournaments (
	id INT AUTO_INCREMENT PRIMARY KEY,
	author INT,
    title VARCHAR(50),
    description VARCHAR(255) DEFAULT '',
    status ENUM('ouvert','fermer'),
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
	UNIQUE KEY pool (number, tournament),
	title VARCHAR(50),
	posX INT,
	posY INT
)
");

createTable("
participants (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user INT,
	tournament INT,
	nickname VARCHAR(20)
)
");

createTable("
captchas(
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

?>
