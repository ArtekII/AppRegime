<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Informations physiques<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Brandy - &Eacute;tape 2</h1>
    <fieldset>
        <h2>Informations physiques</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif; ?>

        <form action="<?= base_url('save') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="email" value="<?= esc($email) ?>">
            <input type="hidden" name="nom" value="<?= esc($nom) ?>">
            <input type="hidden" name="password" value="<?= esc($password) ?>">
            <input type="hidden" name="genre" value="<?= esc($genre) ?>">

            <p>Taille (en cm) <input type="number" step="0.1" name="taille" required></p>
            <p>Poids (en kg) <input type="number" step="0.1" name="poids" required></p>

            <input type="submit" value="Continuer vers le choix d'objectif">
        </form>
    </fieldset>
<?= $this->endSection() ?>
