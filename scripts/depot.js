var stripe = Stripe(stripePublicKey);
var elements = null;
var montant = 0;

function choisirMontant(valeur) {
    montant = valeur;
    document.getElementById('montant-custom').value = '';
    initialiserPaiement();
}

document.getElementById('montant-custom').addEventListener('input', function() {
    montant = parseInt(this.value);
    if (montant > 0) {
        initialiserPaiement();
    }
});

function initialiserPaiement() {
    document.getElementById('btn-payer').disabled = true;
    document.getElementById('payment-element').innerHTML = '';

    fetch('?page=api_stripe_intent', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'montant=' + montant
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.error) {
            document.getElementById('depot-message').innerText = data.error;
            return;
        }

        elements = stripe.elements({ clientSecret: data.clientSecret });
        var paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        paymentElement.on('ready', function() {
            document.getElementById('btn-payer').disabled = false;
        });
    });
}

document.getElementById('btn-payer').addEventListener('click', function() {
    if (!elements) return;

    document.getElementById('btn-payer').disabled = true;
    document.getElementById('depot-message').innerText = '';

    stripe.confirmPayment({
        elements: elements,
        confirmParams: {
            return_url: window.location.href.split('?')[0] + '?page=depot_confirm'
        }
    }).then(function(result) {
        if (result.error) {
            document.getElementById('depot-message').innerText = result.error.message;
            document.getElementById('btn-payer').disabled = false;
        }
    });
});