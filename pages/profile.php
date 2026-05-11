<?php

$email = "hugolemaire77410@gmail.com";
$subject = "TEST";
$contenu = "ceci est un test de debug";
$user_id = "1";

SendMail($email, $subject, $contenu);
verifMail($user_id, $email);

echo <h1>DEBUG</h1>;

?>