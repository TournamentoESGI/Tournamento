<?php
$password = password_hash("ez", PASSWORD_DEFAULT);
$sql = "
INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('ez', 'Ghost', 'Rex', '2000-11-06', '12 34 56 78 90', 'pat_rick@gmail.com', '".$password."', 'Admin');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('tacos', 'Caporal', 'Zzz', '2004-01-01', '34 56 78 90 12', 'anthony@gmail.com', '".$password."', 'Membre');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date)
VALUES('Hugy', 'Hug', 'Maire', '2006-01-01', '33 44 55 66 77', 'hugy@gmail.com', '".$password."', 'Membre', '2025-10-11');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date)
VALUES('Lalo', 'Edwardo', 'Salamanca', '1969-11-06', '44 55 66 77 88', 'sal@gmail.com', '".$password."', 'Membre', '2025-11-11');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role, creation_date)
VALUES('Heisenberg', 'Walter', 'White', '1969-11-06', '11 55 66 77 88', 'wal@gmail.com', '".$password."', 'Membre', '2025-11-11');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('SaulGoodman', 'Jimmy', 'McGuill', '2004-01-01', '33 56 78 90 12', 'bcs@gmail.com', '".$password."', 'Membre');

INSERT INTO users(username, first_name, last_name, date_of_birth, phone, email_address, password, role)
VALUES('Ignacio', 'Nacho', 'Varga', '2004-01-01', '32 56 78 90 12', 'ign@gmail.com', '".$password."', 'Membre');

INSERT INTO tournaments(author, title)
VALUES(1, 'My tournament');

INSERT INTO tournaments(author, title)
VALUES(1, 'A');

INSERT INTO tournaments(author, title)
VALUES(1, 'B');


INSERT INTO pools(title, number, tournament, posX, posY)
VALUES('Test pool', 1, 1, 0, 0);

INSERT INTO pools(title, number, tournament, posX, posY)
VALUES('Test pool', 2, 1, 50, 0);

INSERT INTO participants(user, tournament, nickname)
VALUES(1, 1, 'Mergez');
INSERT INTO participants(user, tournament, nickname)
VALUES(2, 1, 'Tacosinus');
INSERT INTO participants(user, tournament, nickname)
VALUES(3, 1, 'Pimento');

INSERT INTO paris(id_participant, id_parieur, somme)
VALUES(1, 1, 50);
INSERT INTO paris(id_participant, id_parieur, somme)
VALUES(3, 1, 70);
";

testSQL($sql);
?>