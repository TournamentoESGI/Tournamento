<?php

function verifieCompteConnecte() {
	if (!isset($_SESSION['id'])) {
		displayPageError("Inacessible sans compte");
	}
}

function verifieCompteRedirige() {
	if (!isset($_SESSION['id'])) {
		header('Location: ?page=login');
	}
	else {
		return true;
	}
	return false;
}

function isBanned() {
    if (!isset($_SESSION['id'])) {
        return;
    }
    global $pdo;

    if (!isset($pdo) || !($pdo instanceof PDO)) {
        return;
    }
    try {
        $stmt = $pdo->prepare("SELECT COUNT(id) FROM banned WHERE user_id = ?");
        $stmt->execute([$_SESSION['id']]);
        $count = (int) $stmt->fetchColumn();
        if ($count > 0) {
            displayPageNotFound();
            exit;
        }
    } catch (Exception $ex) {
        displayPageError('Erreur lors de la vérification du statut de bannissement.');
        exit;
    }
}

function verifieRoleAdmin() {
    $user_role = $_SESSION['role'] ?? null;
    
    if ($user_role !== 'Admin') {
        displayPageNotFound();
        exit;
    }
}

function hasAdminRole() {
    $user_role = $_SESSION['role'] ?? "";
    return $user_role === 'Admin';

}

function isPhoneValid($phone) {
    $phone_clean = str_replace(' ', '', $phone);
    if(strlen($phone_clean) !== 10) {
        return false;
    }
    if(!is_numeric($phone_clean)) {
        return false;
    }
    return true;
}
?>
