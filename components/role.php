<?php

function role() {
    $user_role = $_SESSION['role'] ?? null;
    
    if ($user_role !== 'Admin') {
        ?>
        <?php include_once("./components/header.php"); ?>
        <div class="denied-container">
            <h1>Access denied</h1>
            <button class="denied-button">
                <a href="<?php echo getPagePath('home') ?>">Retour au site</a>
            </button>
        </div>
        <?php
        include_once("./components/footer.php");
        exit;
    }
}

?>