<?php

$tables = [];

function createTable($new_table) {
    global $tables;
    $table_name = trim(explode("(", $new_table)[0]);
    $query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (" . explode("(", $new_table, 2)[1] . ";";
    array_push($tables, ["name" => $table_name, "query" => $query]);
}

    function deleteDatabase() {
    global $tables;
    global $pdo;
    foreach($tables as $table) {
        $query = "DROP TABLE IF EXISTS `" . $table["name"] . "`;";
        $pdo->exec($query);
    }
}

function makeDatabase() {
    global $tables;
    global $pdo;
    foreach($tables as $table) {
        $pdo->exec($table["query"]);
    }
}
createTable("
users (
    id_users INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    current_balance DECIMAL(10,2) DEFAULT 0,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    profil_picture VARCHAR(255) DEFAULT 'default_profile_picture.png'
)
");

createTable("
tournaments (
    id_tournaments INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    description VARCHAR(255),
    games VARCHAR(50),
    status ENUM('ouvert', 'fermé'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL
)
");

createTable("
pools (
    id_pools INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50)
)
");

createTable("
captchas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img_url VARCHAR(50),
    posX INT,
    posY INT,
    scale INT
)
");
?>