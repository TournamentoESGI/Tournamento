<?php
$password = password_hash("ez", PASSWORD_DEFAULT);
$sql = "
INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, current_balance, is_verified)
VALUES ('ez', 'Ghost', 'Rex', '2000-11-06', '12 34 56 78 90', 'p.nikiel@myskolae.fr', '".$password."', 'Admin', 100, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, current_balance, is_verified)
VALUES ('tacos', 'Caporal', 'Zzz', '2004-01-01', '34 56 78 90 12', 'a.zhao@myskolae.fr', '".$password."', 'Membre', 0, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date, current_balance, is_verified)
VALUES ('Hugy', 'Hug', 'Maire', '2006-01-01', '33 44 55 66 77', 'h.lemaire@myskolae.fr', '".$password."', 'Membre', '2025-10-11', 0, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date, current_balance, is_verified)
VALUES ('Lalo', 'Edwardo', 'Salamanca', '1969-11-06', '44 55 66 77 88', 'sal@gmail.com', '".$password."', 'Membre', '2025-11-11', 0, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date, current_balance, is_verified)
VALUES ('Heisenberg', 'Walter', 'White', '1969-11-06', '11 55 66 77 88', 'wal@gmail.com', '".$password."', 'Membre', '2025-11-11', 0, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, current_balance, is_verified)
VALUES ('SaulGoodman', 'Jimmy', 'McGuill', '2004-01-01', '33 56 78 90 12', 'bcs@gmail.com', '".$password."', 'Membre', 0, 1);

INSERT INTO users (username, first_name, last_name, date_of_birth, phone, email_address, password, role, current_balance, is_verified)
VALUES ('Ignacio', 'Nacho', 'Varga', '2004-01-01', '32 56 78 90 12', 'ign@gmail.com', '".$password."', 'Membre', 0, 1);


INSERT INTO tournaments(author, title, status)
VALUES(1, 'Tournoi Populaire', 'open');

INSERT INTO tournaments(author, title, status)
VALUES(1, 'Tournoi Parie', 'open');

INSERT INTO tournaments(author, title, status)
VALUES(1, 'Tournoi Equilibre', 'closed');

INSERT INTO tournaments(author, title, status)
VALUES(1, 'Tournoi Vide', 'open');

INSERT INTO tournaments(author, title, status)
VALUES(1, 'Tournoi En Edition', 'edit');



INSERT INTO pools(title, number, tournament, posX, posY)
VALUES('Test pool', 1, 1, 0, 200);

INSERT INTO pools(title, number, tournament, posX, posY)
VALUES('Test pool', 2, 1, 300, 0);



INSERT INTO participants(user, tournament, nickname)
VALUES(2, 1, 'Tacosinus');

INSERT INTO participants(user, tournament, nickname)
VALUES(3, 1, 'Bourgimignon');

INSERT INTO participants(user, tournament, nickname)
VALUES(4, 1, 'Pimento');



INSERT INTO paris(id_participant, id_parieur, somme, status)
VALUES(1, 1, 50, 'en cours');

INSERT INTO paris(id_participant, id_parieur, somme, status)
VALUES(2, 1, 70, 'en cours');

";

for ($i = 1; $i <= 20; $i++) {
    $sql .= "
    INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
    VALUES('TestUser$i', 'Prenom$i', 'Nom$i', '2000-01-01', '00 00 00 00 $i', 'test$i@gmail.com', '".$password."', 'Membre');
    ";
}

testSQL($sql);
?>  