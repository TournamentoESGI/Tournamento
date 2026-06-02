<form method="POST">
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

    <button type="submit">Créer la tâche</button>
</form>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $frequency = $_POST['frequency'];

    $stmt = $pdo->prepare("INSERT INTO auto_mails (subject, content, frequency) VALUES (?, ?, ?)");
    $stmt->execute([$subject, $content, $frequency]);

    echo "<p>Tâche programmée !</p>";
}

?>