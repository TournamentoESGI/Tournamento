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
