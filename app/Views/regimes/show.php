<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Detail regime<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1><?= esc($regime['nom'] ?? 'Regime') ?></h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $regime = $regime ?? []; ?>

    <section class="dashboard-card">
        <p><strong>ID:</strong> <?= esc($regime['id']) ?></p>
        <p><strong>Viandes:</strong> <?= esc($regime['pourcentage_viandes']) ?>%</p>
        <p><strong>Poissons:</strong> <?= esc($regime['pourcentage_poissons']) ?>%</p>
        <p><strong>Volailles:</strong> <?= esc($regime['pourcentage_volailles']) ?>%</p>

        <p>
            <a href="<?= site_url('regime/edit/' . $regime['id']) ?>">Modifier</a>
            <a href="<?= site_url('regime/delete/' . $regime['id']) ?>" onclick="return confirm('Supprimer ce regime ?')">Supprimer</a>
            <a href="<?= site_url('regime') ?>">Retour</a>
        </p>
    </section>
<?= $this->endSection() ?>
