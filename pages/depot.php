<?php
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    die();
}
$stripePublicKey = $env['STRIPE_PUBLIC'];
?>

<div class="background-presentation">

    <div class="depot-all">

        <div class="depot-form-section">
            <h2>Montant à déposer</h2>
            <div class="depot-montants">
                <button class="btn-montant" onclick="choisirMontant(10)">10 €</button>
                <button class="btn-montant" onclick="choisirMontant(20)">20 €</button>
                <button class="btn-montant" onclick="choisirMontant(50)">50 €</button>
                <button class="btn-montant" onclick="choisirMontant(100)">100 €</button>
            </div>
            <input type="number" id="montant-custom" placeholder="Autre montant (€)" min="1">
        </div>

        <div class="depot-paiement-section">
            <h2>Paiement</h2>
            <div id="payment-element"></div>
            <div id="depot-message"></div>
            <button class="btn-payer" id="btn-payer" disabled>Payer</button>
        </div>

    </div>

</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripePublicKey = "<?php echo $stripePublicKey; ?>";
</script>
<?php include_js('./scripts/depot.js'); ?>