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
        <?php if (! empty($isGold)): ?>
            <p><span class="discount-badge">Gold actif: 15% de remise appliquee sur tous les regimes.</span></p>
        <?php endif; ?>

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
                        <?php
                            $prixInitial = (float) $prixRegime['prix'];
                            $prixFinal = ! empty($isGold) ? round($prixInitial * (1 - (float) $goldDiscountRate), 2) : $prixInitial;
                        ?>
                        <tr>
                            <td><?= esc($prixRegime['duree_jours']) ?> jours</td>
                            <td>
                                <?php if (! empty($isGold)): ?>
                                    <span class="price-original"><?= number_format($prixInitial, 2, ',', ' ') ?> Ar</span>
                                    <strong><?= number_format($prixFinal, 2, ',', ' ') ?> Ar</strong>
                                    <span class="discount-badge">Gold -15%</span>
                                <?php else: ?>
                                    <?= number_format($prixFinal, 2, ',', ' ') ?> Ar
                                <?php endif; ?>
                            </td>
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
