<?php
function SendMail($email, $sujet, $contenu) {
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreplytournamento@gmail.com';
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    
        $mail->setFrom('noreplytournamento@gmail.com', 'no-replytournamento');
        $mail->addAddress($email);
    
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body    = $contenu;
    
        $mail->send();
        echo 'Email envoyé !';
    } catch (Exception $e) {
        echo "Erreur : {$mail->ErrorInfo}";
    }
}
?>