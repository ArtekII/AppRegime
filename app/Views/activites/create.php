<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Creer une activite<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Creer une activite sportive</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="dashboard-card">
        <form action="<?= site_url('activite/store') ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="nom">Nom</label><br>
                <input type="text" id="nom" name="nom" value="<?= esc(old('nom')) ?>" required>
            </p>

            <p>
                <label for="calories_brulees_par_heure">Calories brulees par heure</label><br>
                <input type="number" id="calories_brulees_par_heure" name="calories_brulees_par_heure" step="0.1" value="<?= esc(old('calories_brulees_par_heure')) ?>" required>
            </p>

            <button type="submit">Creer</button>
            <a href="<?= site_url('activite') ?>">Annuler</a>
        </form>
    </section>
<?= $this->endSection() ?>
