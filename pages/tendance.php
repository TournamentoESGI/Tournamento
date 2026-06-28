<?php
$isAdmin = isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';

if ($isAdmin && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM tournaments WHERE id = ?");
    $stmt->execute([$deleteId]);
}

$stmt = $pdo->query("SELECT id, title, status FROM tournaments WHERE status != 'edit'");
$tournois = $stmt->fetchAll();
?>

<div class="tendance-banner">
    <p class="tendance-tag">Tournois Tendances</p>
    <h1>Les tournois du moment,</h1>
    <h2>Découvrez les compétitions les plus populaires</h2>
</div>

<div class="tendance-global">
    <p class="tendance-badge">Tout les Tournois</p>

    <div class="tendance-list">
        <?php
        if (count($tournois) == 0) {
            echo "<p>Aucun tournoi disponible.</p>";
        }
        foreach ($tournois as $index => $tournoi) {
            $rang = $index + 1;
            echo "<div class='tendance-row'>";
                echo "<a href='?page=preview&id=".$tournoi['id']."' class='row-name'>".$tournoi['title']."</a>";
                echo "<p class='tendance-row-status'>".$tournoi['status']."</p>";
                if ($isAdmin) {
                    echo "<form method='POST'>";
                        echo "<input type='hidden' name='delete_id' value='".$tournoi['id']."'>";
                        echo "<button type='submit' class='btn-supprimer' onclick='return confirm(\"Supprimer ce tournoi ?\")'>Supprimer</button>";
                    echo "</form>";
                }
            echo "</div>";
        }
        ?>
    </div>
</div>