<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Achat Abonnement Gold<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Abonnement Gold</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <section class="section">
        <h2>Acheter l'abonnement Gold - <?= number_format((float) $prixGold, 2, ',', ' ') ?> Ar</h2>
        <?php if (! empty($utilisateur)): ?>
            <p>Solde actuel: <strong><?= number_format((float) $utilisateur['solde'], 2, ',', ' ') ?> Ar</strong></p>
        <?php endif; ?>

        <form action="<?= site_url('paiement/traiter-achat') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" id="montant" name="montant" value="<?= esc($prixGold) ?>">

            <fieldset class="inline-fieldset">
                <legend>Methode de paiement</legend>
                <label><input type="radio" name="methode_paiement" value="carte" required> Carte bancaire</label>
                <label><input type="radio" name="methode_paiement" value="paypal"> PayPal</label>
                <label><input type="radio" name="methode_paiement" value="portefeuille"> Portefeuille</label>
            </fieldset>

            <div id="carte_details" class="is-hidden">
                <h3>Details de la carte</h3>
                <p>
                    <label for="numero_carte">Numero de carte</label><br>
                    <input type="text" id="numero_carte" name="numero_carte" placeholder="1234 5678 9012 3456">
                </p>
                <p>
                    <label for="date_expiration">Date d'expiration</label><br>
                    <input type="text" id="date_expiration" name="date_expiration" placeholder="MM/YY">
                </p>
                <p>
                    <label for="cvv">CVV</label><br>
                    <input type="text" id="cvv" name="cvv" placeholder="123">
                </p>
            </div>

            <div id="paypal_details" class="is-hidden">
                <h3>Details PayPal</h3>
                <p>
                    <label for="email_paypal">Email PayPal</label><br>
                    <input type="email" id="email_paypal" name="email_paypal">
                </p>
            </div>

            <button type="submit">Confirmer l'achat</button>
        </form>
    </section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const carteDetails = document.getElementById('carte_details');
        const paypalDetails = document.getElementById('paypal_details');
        const paymentRadios = document.querySelectorAll('input[name="methode_paiement"]');

        paymentRadios.forEach((radio) => {
            radio.addEventListener('change', () => {
                carteDetails.classList.toggle('is-hidden', radio.value !== 'carte');
                paypalDetails.classList.toggle('is-hidden', radio.value !== 'paypal');
            });
        });
    </script>
<?= $this->endSection() ?>
