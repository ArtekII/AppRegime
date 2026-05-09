<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Connexion<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="auth-panel">
        <h1>Connexion</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif; ?>

        <form action="<?= base_url('authenticate') ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="login_email">Email</label><br>
                <input type="email" id="login_email" name="login_email" required>
            </p>

            <p>
                <label for="login_password">Mot de passe</label><br>
                <input type="password" id="login_password" name="login_password" required>
            </p>

            <button type="submit">Se connecter</button>
        </form>

        <p class="muted">
            Pas encore de compte ?
            <a href="<?= site_url('inscription') ?>">Creer un compte</a>
        </p>
    </section>
<?= $this->endSection() ?>
