<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>D&eacute;tail du r&eacute;gime<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <p><a href="<?= previous_url() ?: site_url('suggestions') ?>">Retour</a></p>

    <h1><?= esc($regime['nom']) ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <section class="section">
        <h2>Composition</h2>
        <p>
            Viandes: <?= esc($regime['pourcentage_viandes']) ?>%<br>
            Poissons: <?= esc($regime['pourcentage_poissons']) ?>%<br>
            Volailles: <?= esc($regime['pourcentage_volailles']) ?>%
        </p>
    </section>

    <section class="section">
        <h2>Prix disponibles</h2>

        <?php if (empty($prixRegimes)): ?>
            <p>Aucun prix disponible pour ce r&eacute;gime.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Dur&eacute;e</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prixRegimes as $prixRegime): ?>
                        <tr>
                            <td><?= esc($prixRegime['duree_jours']) ?> jours</td>
                            <td><?= number_format((float) $prixRegime['prix'], 2, ',', ' ') ?> Ar</td>
                            <td>
                                <form action="<?= site_url('regimes/acheter') ?>" method="post" class="inline-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="prix_regime_id" value="<?= esc($prixRegime['id']) ?>">
                                    <button type="submit">Acheter</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>
