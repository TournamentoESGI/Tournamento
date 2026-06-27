<?php

if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    die();
}

require_once __DIR__ . '/../vendor/autoload.php';

\Stripe\Stripe::setApiKey($env['STRIPE_SECRET']);

$paymentIntentId = isset($_GET['payment_intent']) ? $_GET['payment_intent'] : '';

if ($paymentIntentId === '') {
    header('Location: ?page=depot');
    die();
}

$intent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

if ($intent->status === 'succeeded') {
    $montant = $intent->amount / 100;
    $stmt = $pdo->prepare("UPDATE users SET current_balance = current_balance + ? WHERE id = ?");
    $stmt->execute([$montant, $_SESSION['id']]);
    $success = true;
} else {
    $success = false;
}
?>

<div class="background-presentation">

    <div class="depot-confirm">
        <?php if ($success): ?>
            <h1>Paiement réussi !</h1>
            <p>Votre solde a été crédité de <?php echo $montant; ?> €.</p>
            <a href="?page=profil" class="btn-retour">Retour au profil</a>
        <?php else: ?>
            <h1>Paiement échoué</h1>
            <p>Une erreur est survenue, votre solde n'a pas été modifié.</p>
            <a href="?page=depot" class="btn-retour">Réessayer</a>
        <?php endif; ?>
    </div>

</div>