<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Gestion des regimes<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Gestion des regimes</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $regimes = $regimes ?? []; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p><a class="button-link" href="<?= site_url('regime/create') ?>">Ajouter un regime</a></p>

    <section class="dashboard-card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Viandes</th>
                    <th>Poissons</th>
                    <th>Volailles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($regimes)): ?>
                    <tr><td colspan="6">Aucun regime enregistre.</td></tr>
                <?php endif; ?>

                <?php foreach ($regimes as $regime): ?>
                    <tr>
                        <td><?= esc($regime['id']) ?></td>
                        <td><?= esc($regime['nom']) ?></td>
                        <td><?= esc($regime['pourcentage_viandes']) ?>%</td>
                        <td><?= esc($regime['pourcentage_poissons']) ?>%</td>
                        <td><?= esc($regime['pourcentage_volailles']) ?>%</td>
                        <td>
                            <a href="<?= site_url('regime/show/' . $regime['id']) ?>">Voir</a>
                            <a href="<?= site_url('regime/edit/' . $regime['id']) ?>">Modifier</a>
                            <a href="<?= site_url('regime/delete/' . $regime['id']) ?>" onclick="return confirm('Supprimer ce regime ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?= $this->endSection() ?>
