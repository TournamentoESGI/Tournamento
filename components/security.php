<?php

function verifieCompteConnecte() {
	if (!isset($_SESSION['id'])) {
		displayPageError("Inacessible sans compte");
	}
}

function isBanned() {
    if (!isset($_SESSION['is_banned'])) {
        return;
    } else {
        $banned = $_SESSION['is_banned'];
    
        if ($banned === 1) {
            displayPageNotFound();
            exit;
        }
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
