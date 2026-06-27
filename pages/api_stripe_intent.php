<?php
ob_end_clean();

require_once __DIR__ . '/../vendor/autoload.php';

$montant = isset($_POST['montant']) ? (int)$_POST['montant'] : 0;

if ($montant <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Montant invalide']);
    die();
}

\Stripe\Stripe::setApiKey($env['STRIPE_SECRET']);

$intent = \Stripe\PaymentIntent::create([
    'amount'   => $montant * 100,
    'currency' => 'eur',
    'automatic_payment_methods' => ['enabled' => true]
]);

header('Content-Type: application/json');
echo json_encode(['clientSecret' => $intent->client_secret]);
die();