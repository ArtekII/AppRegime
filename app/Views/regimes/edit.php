<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Modifier un regime<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Modifier un regime</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $regime = $regime ?? []; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <section class="dashboard-card">
        <form action="<?= site_url('regime/update/' . $regime['id']) ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="nom">Nom</label><br>
                <input type="text" id="nom" name="nom" value="<?= esc(old('nom') ?? $regime['nom']) ?>" required>
            </p>

            <p>
                <label for="pourcentage_viandes">Pourcentage de viandes</label><br>
                <input type="number" id="pourcentage_viandes" name="pourcentage_viandes" step="0.1" min="0" max="100" value="<?= esc(old('pourcentage_viandes') ?? $regime['pourcentage_viandes']) ?>" required>
            </p>

            <p>
                <label for="pourcentage_poissons">Pourcentage de poissons</label><br>
                <input type="number" id="pourcentage_poissons" name="pourcentage_poissons" step="0.1" min="0" max="100" value="<?= esc(old('pourcentage_poissons') ?? $regime['pourcentage_poissons']) ?>" required>
            </p>

            <p>
                <label for="pourcentage_volailles">Pourcentage de volailles</label><br>
                <input type="number" id="pourcentage_volailles" name="pourcentage_volailles" step="0.1" min="0" max="100" value="<?= esc(old('pourcentage_volailles') ?? $regime['pourcentage_volailles']) ?>" required>
            </p>

            <button type="submit">Mettre a jour</button>
            <a href="<?= site_url('regime') ?>">Annuler</a>
        </form>
    </section>
<?= $this->endSection() ?>
