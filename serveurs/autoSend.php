<?php

include_once("./components/error.php");
include_once("./components/utilities.php");
include_once("./systems/config.php");
include_once("./components/mail.php");

try {
    $stmt = $pdo->query("SELECT id, subject, content, frequency, last_sent FROM auto_mails");
    $tasks = $stmt->fetchAll();

    $stmtUser = $pdo->query("SELECT email_address FROM users WHERE is_verified = 1");
    $users = $stmtUser->fetchAll();

    if(!empty($users) && !empty($tasks)) {
        $now = new DateTime();

        foreach ($tasks as $task) {
            $shouldSend = false;

            if(empty($task['last_sent'])) {
                $shouldSend = true;
            } else {
                $lastSend = new DateTime($task['last_sent']);
                $interval = $now->diff($lastSend);
                
                switch ($task['frequency']) {
                    case 'daily':
                        if($interval->days >= 1) $shouldSend = true;
                        break;
                    case 'weekly':
                        if($interval->days >= 7) $shouldSend = true;
                        break;
                    case 'monthly':
                        if($interval->m >= 1 || $interval->y >= 1) $shouldSend = true;
                        break;
                }
            }

            if($shouldSend) {
                foreach ($users as $user) {
                    SendMail($user['email_address'], $task['subject'], $task['content']);
                }

                $stmtUpdate = $pdo->prepare("UPDATE auto_mails SET last_sent = NOW() WHERE id = ?");
                $stmtUpdate->execute([$task['id']]);

                sendLog($task['subject'], "mail_auto");
            }
        }
    }

    $inactivity_days = 30;

    $stmtInactive = $pdo->prepare("
        SELECT id, email_address 
        FROM users 
        WHERE is_verified = 1 
        AND last_activity < DATE_SUB(NOW(), INTERVAL ? DAY)
        AND inactive_mail_sent = 0
    ");
    $stmtInactive->execute([$inactivity_days]);
    $inactiveUsers = $stmtInactive->fetchAll();

    if (!empty($inactiveUsers)) {
        $subject = "Vous nous manquez sur Tournamento !";
        $content = "
            <h1>Bonjour,</h1>
            <p>Cela fait un petit moment que nous n'avons pas vu d'activité de votre part sur Tournamento.</p>
            <p>De nombreux tournois et nouveautés vous attendent. N'hésitez pas à revenir faire un tour !</p>
            <br>
            <a href='https://tournamento.ovh/?page=login'>Me reconnecter</a>
        ";

        foreach ($inactiveUsers as $user) {
            SendMail($user['email_address'], $subject, $content);

            $stmtMarkSent = $pdo->prepare("UPDATE users SET inactive_mail_sent = 1 WHERE id = ?");
            $stmtMarkSent->execute([$user['id']]);

            sendLog("Relance inactivité envoyée à " . $user['email_address'], "mail_auto_inactive");
        }
    }

} catch (Exception $ex) {
    echo "Erreur lors de l'exécution d'autoSend : " . $ex->getMessage() . "\n";
}

?>