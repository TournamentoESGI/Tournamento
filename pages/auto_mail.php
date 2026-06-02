<div class="auto-mail-presentation">

    <form class="Auto-mail-container" method="POST">

        <h1 class="Titre-container">Tableau de Bord: Mail Récurrent</h1>

        <label>Objet :</label>
        <input type="text" name="subject" required>

        <label>Contenu :</label>
        <textarea name="content" required></textarea>

        <label>Fréquence :</label>
        <select name="frequency">
            <option value="daily">Tous les jours</option>
            <option value="weekly">Toutes les semaines</option>
            <option value="monthly">Tous les mois</option>
        </select>

        <button class="btn-submit" type="submit" name="action" value="create">Créer la tâche</button>
    </form>

    <div class="mail-list-container">
        <h1 class="mail-list-title">Mail Recurrent :</h1>

        <?php 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'delete') {
                $id = intval($_POST['delete_id']);
                $stmt = $pdo->prepare("SELECT subject FROM auto_mails WHERE id = ?");
                $stmt->execute([$id]);
                $task = $stmt->fetch();
                if ($task) {
                    sendLog($task['subject'], "delete_mail_auto");
                }
                $stmt = $pdo->prepare("DELETE FROM auto_mails WHERE id = ?");
                $stmt->execute([$id]);
                echo "<p class='message-info'>Tâche supprimée !</p>";
            }

            if (isset($_POST['action']) && $_POST['action'] === 'create') {
                $subject = $_POST['subject'];
                $content = $_POST['content'];
                $frequency = $_POST['frequency'];
                $stmt = $pdo->prepare("INSERT INTO auto_mails (subject, content, frequency) VALUES (?, ?, ?)");
                $stmt->execute([$subject, $content, $frequency]);
                echo "<p class='message-info'>Tâche programmée !</p>";
            }
        }

        ?>

        <?php 
        try {
            $stmt = $pdo->query("SELECT id, subject, content, frequency, last_sent FROM auto_mails");
            $tasks = $stmt->fetchAll();
            
            if (empty($tasks)) {
                echo "<p class='message-info'>Aucun mail récurrent programmé !</p>";
            } else {
                foreach ($tasks as $task) {
                    echo "
                    <div class='mail-card'>
                        <h3 class='mail-card-title'>{$task['subject']}</h3>
                        <p class='mail-card-text'>Contenu : {$task['content']}</p>
                        <p class='mail-card-text'>Fréquence : {$task['frequency']}</p>
                        <p class='mail-card-text'>Dernier envoi : " . ($task['last_sent'] ?: "Jamais") . "</p>
                        <form class='mail-card-delete-form' method='POST' onsubmit='return confirm(\"Supprimer cette tâche ?\");'>
                            <input type='hidden' name='delete_id' value='{$task['id']}'>
                            <button class='btn-delete' type='submit' name='action' value='delete'>Supprimer</button>
                        </form>
                    </div>
                    ";
                }
            }
        } catch (Exception $ex) {
            displayPageException($ex);
        }
        ?>

    </div>

</div>