<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Accueil<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Bienvenue<?= ! empty($utilisateur['nom']) ? ', ' . esc($utilisateur['nom']) : '' ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (! empty($utilisateur)): ?>
        <section class="profile">
            <h2>Votre profil</h2>
            <p>
                Email: <?= esc($utilisateur['email']) ?><br>
                Genre: <?= esc($utilisateur['genre']) ?><br>
                Taille: <?= esc($utilisateur['taille']) ?> cm<br>
                Poids: <?= esc($utilisateur['poids']) ?> kg<br>
                Solde: <strong><?= number_format((float) $utilisateur['solde'], 2, ',', ' ') ?> Ar</strong>
            </p>
        </section>
    <?php endif; ?>

    <section class="section">
        <h2>Votre parcours</h2>
        <?php if (! empty($utilisateurObjectif)): ?>
            <p>Votre objectif est enregistr&eacute;. Vous pouvez consulter vos suggestions.</p>
            <p>
                <a href="<?= site_url('suggestions?objectif_id=' . $utilisateurObjectif['objectif_id']) ?>">
                    Voir mes suggestions
                </a>
            </p>
        <?php else: ?>
            <p>Choisissez un objectif pour obtenir vos suggestions personnalis&eacute;es.</p>
            <p><a href="<?= site_url('objectifs') ?>">Choisir mon objectif</a></p>
        <?php endif; ?>
    </section>

    <section class="section">
        <h2>Solde</h2>
        <p>Ajoutez du credit a votre compte avec un code.</p>
        <p><a href="<?= site_url('code/use') ?>">Utiliser un code</a></p>
        <p><a href="<?= site_url('paiement/achat-gold') ?>">Acheter l'abonnement Gold</a></p>
    </section>
<?= $this->endSection() ?>
