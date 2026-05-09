<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat Abonnement Gold</title>
</head>
<body>
    <?php $prixGold = $prixGold ?? 9.99; ?>
    <h1>Abonnement Gold</h1>

    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <fieldset>
        <h2>Acheter l'abonnement Gold - <?= $prixGold ?> €</h2>

        <form action="<?= base_url('paiement/traiter-achat') ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="utilisateur_id">Identifiant utilisateur:</label>
                <input type="number" id="utilisateur_id" name="utilisateur_id" required>
            </p>

            <p>
                <label for="montant">Montant:</label>
                <input type="number" id="montant" name="montant" step="0.01" value="<?= $prixGold ?>" readonly>
            </p>

            <p>
                <label>Méthode de paiement:</label>
                <input type="radio" id="carte" name="methode_paiement" value="carte" required onchange="changerMethode('carte')">
                <label for="carte">Carte bancaire</label>
                <input type="radio" id="paypal" name="methode_paiement" value="paypal" onchange="changerMethode('paypal')">
                <label for="paypal">PayPal</label>
                <input type="radio" id="portefeuille" name="methode_paiement" value="portefeuille" onchange="changerMethode('portefeuille')">
                <label for="portefeuille">Portefeuille</label>
            </p>

            <div id="carte_details" style="display:none;">
                <h3>Détails de la carte</h3>
                <p>
                    <label for="numero_carte">Numéro de carte:</label>
                    <input type="text" id="numero_carte" name="numero_carte" placeholder="1234 5678 9012 3456">
                </p>
                <p>
                    <label for="date_expiration">Date d'expiration:</label>
                    <input type="text" id="date_expiration" name="date_expiration" placeholder="MM/YY">
                </p>
                <p>
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123">
                </p>
            </div>

            <div id="paypal_details" style="display:none;">
                <h3>Détails PayPal</h3>
                <p>
                    <label for="email_paypal">Email PayPal:</label>
                    <input type="email" id="email_paypal" name="email_paypal">
                </p>
            </div>

            <input type="submit" value="Confirmer l'achat">
        </form>
    </fieldset>

    <script>
        function changerMethode(methode) {
            document.getElementById('carte_details').style.display = (methode === 'carte') ? 'block' : 'none';
            document.getElementById('paypal_details').style.display = (methode === 'paypal') ? 'block' : 'none';
        }
    </script>
</body>
</html>
