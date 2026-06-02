<?php

include_once("./components/error.php");
include_once("./components/utilities.php");
include_once("./systems/config.php");

try {
    $stmt = $pdo->query("SELECT id, subject, content, frequency, last_sent FROM auto_mails");
    $tasks = $stmt->fetchAll();

    $stmtUser = $pdo->query("SELECT email_address FROM users WHERE is_verified = 1");
    $users = $stmtUser->fetchAll();

    if(empty($users)) {
        die("Aucun destinataire trouvé. \n");
    }

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
} catch (Exception $ex) {
    echo $ex;
}

?>