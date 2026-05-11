<?php
require '/var/www/Tournamento/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function SendMail($email, $subject, $contenu) {

    $env = parse_ini_file(__DIR__ . '/../.env');
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreplytournamento@gmail.com';
        $mail->Password   = $env['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('noreplytournamento@gmail.com', 'no-replytournamento');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $contenu;
        $mail->send();
        echo 'Email envoyé !';
    } catch (Exception $e) {
        echo "Erreur : {$mail->ErrorInfo}";
    }
}

function verifMail($user_id, $email) {
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", time() + 60*60);
    $link = "https://tournamento.ovh/pages/verify.php?token=" . $token;

    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO email_verification (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $token, $expires]);

    $subject = "Vérifier votre compte Tournamento";
    $contenu = "
        <h1>Bienvenue</h1>
        <p>Cliquez ci-dessous pour valider votre compte :</p>
        <a href='$link' style='padding: 12px 20px; background:#007bff; color:white; text-decoration:none; border-radius:6px;'>Valider mon compte</a>
    ";
    SendMail($email, "Verifiez votre compte Tournamento", $contenu);
}