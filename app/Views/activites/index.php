<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Gestion des activites<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Gestion des activites sportives</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $activites = $activites ?? []; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p><a class="button-link" href="<?= site_url('activite/create') ?>">Ajouter une activite</a></p>

    <section class="dashboard-card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Calories brulees/heure</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($activites)): ?>
                    <tr><td colspan="4">Aucune activite enregistree.</td></tr>
                <?php endif; ?>

                <?php foreach ($activites as $activite): ?>
                    <tr>
                        <td><?= esc($activite['id']) ?></td>
                        <td><?= esc($activite['nom']) ?></td>
                        <td><?= esc($activite['calories_brulees_par_heure']) ?></td>
                        <td>
                            <a href="<?= site_url('activite/show/' . $activite['id']) ?>">Voir</a>
                            <a href="<?= site_url('activite/edit/' . $activite['id']) ?>">Modifier</a>
                            <a href="<?= site_url('activite/delete/' . $activite['id']) ?>" onclick="return confirm('Supprimer cette activite ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?= $this->endSection() ?>
