<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Authentification<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Brandy</h1>

    <fieldset>
        <h2>Sign up (Inscription)</h2>
        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <p>Email <input type="email" name="email" id="email" required></p>
            <p>Nom <input type="text" name="nom" required></p>
            <p>Mot de passe <input type="password" name="password" required></p>

            <label><input type="radio" name="genre" value="Homme" required> Homme</label>
            <label><input type="radio" name="genre" value="Femme"> Femme</label>
            <label><input type="radio" name="genre" value="Autre"> Autre</label>

            <input type="submit" value="Poursuivre l'inscription">
        </form>
    </fieldset>

    <br>

    <fieldset>
        <h2>Sign in (Connexion)</h2>
        <form action="<?= base_url('authenticate') ?>" method="post">
            <?= csrf_field() ?>
            <p>Email: <input type="email" name="login_email" required></p>
            <p>Mot de passe: <input type="password" name="login_password" required></p>

            <?php if (session()->getFlashdata('error')): ?>
                <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
            <?php endif; ?>

            <input type="submit" value="Se connecter">
        </form>
    </fieldset>
<?= $this->endSection() ?>
