<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Detail activite<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1><?= esc($activite['nom'] ?? 'Activite') ?></h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $activite = $activite ?? []; ?>

    <section class="dashboard-card">
        <p><strong>ID:</strong> <?= esc($activite['id']) ?></p>
        <p><strong>Calories brulees par heure:</strong> <?= esc($activite['calories_brulees_par_heure']) ?></p>

        <p>
            <a href="<?= site_url('activite/edit/' . $activite['id']) ?>">Modifier</a>
            <a href="<?= site_url('activite/delete/' . $activite['id']) ?>" onclick="return confirm('Supprimer cette activite ?')">Supprimer</a>
            <a href="<?= site_url('activite') ?>">Retour</a>
        </p>
    </section>
<?= $this->endSection() ?>
