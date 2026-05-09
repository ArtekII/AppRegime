<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Pages de suggestions<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Nous avons des suggestions pr&ecirc;tes &agrave; &ecirc;tre choisies.</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (! empty($utilisateurId)): ?>
        <form action="<?= base_url('objectifs/submit') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="utilisateur_id" value="<?= esc($utilisateurId) ?>">
    <?php else: ?>
        <form action="<?= base_url('suggestions') ?>" method="get">
    <?php endif; ?>
        <label for="objectif_id">Modifier l'objectif</label>
        <select name="<?= ! empty($utilisateurId) ? 'objectif' : 'objectif_id' ?>" id="objectif_id" required>
            <option value="">-- S&eacute;lectionnez un objectif --</option>
            <?php foreach ($objectifs as $objectif): ?>
                <option
                    value="<?= esc($objectif['id']) ?>"
                    data-imc="<?= stripos($objectif['type'], 'IMC') !== false ? '1' : '0' ?>"
                    <?= (int) $objectifId === (int) $objectif['id'] ? 'selected' : '' ?>
                >
                    <?= esc($objectif['type']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <p id="imc-cible-field" class="is-hidden">
            <label for="imc_cible">IMC cible souhait&eacute;</label>
            <input
                type="number"
                name="imc_cible"
                id="imc_cible"
                min="18.5"
                max="24.9"
                step="0.1"
                value="<?= esc(old('imc_cible') ?? $imcCible ?? '22.0') ?>"
            >
        </p>

        <button type="submit">
            <?= ! empty($utilisateurId) ? 'Modifier et enregistrer' : 'Voir les suggestions' ?>
        </button>
    </form>

    <?php if ($objectifId > 0): ?>
        <p>
            <a class="button-link" href="<?= site_url('suggestions/export-pdf?objectif_id=' . $objectifId) ?>">
                Exporter en PDF
            </a>
        </p>

        <div class="suggestions">
            <section class="section">
                <h2>Suggestions R&eacute;gimes</h2>

                <?php if (empty($regimes)): ?>
                    <p class="muted">Aucun r&eacute;gime disponible pour cet objectif.</p>
                <?php endif; ?>

                <?php foreach ($regimes as $regime): ?>
                    <div class="item">
                        <strong><?= esc($regime['regime_nom']) ?></strong>
                        <p>
                            Poids cible: <?= esc($regime['poids_min']) ?> kg &agrave; <?= esc($regime['poids_max']) ?> kg<br>
                            Dur&eacute;e: <?= esc($regime['duree_jours']) ?> jours<br>
                            Prix:
                            <?php if (! empty($regime['prix'])): ?>
                                <?php
                                    $prixInitial = (float) $regime['prix'];
                                    $prixFinal = ! empty($isGold) ? round($prixInitial * (1 - (float) $goldDiscountRate), 2) : $prixInitial;
                                ?>
                                <?php if (! empty($isGold)): ?>
                                    <span class="price-original"><?= number_format($prixInitial, 2, ',', ' ') ?> Ar</span>
                                    <strong><?= number_format($prixFinal, 2, ',', ' ') ?> Ar</strong>
                                    <span class="discount-badge">Gold -15%</span>
                                <?php else: ?>
                                    <?= number_format($prixFinal, 2, ',', ' ') ?> Ar
                                <?php endif; ?>
                            <?php else: ?>
                                non disponible
                            <?php endif; ?>
                            <br>
                            <a href="<?= site_url('regimes/details/' . $regime['regime_id']) ?>">Voir les d&eacute;tails</a>
                            <?php if (! empty($regime['prix_regime_id']) && ! empty($regime['prix'])): ?>
                                <form action="<?= site_url('regimes/acheter') ?>" method="post" class="inline-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="prix_regime_id" value="<?= esc($regime['prix_regime_id']) ?>">
                                    <button type="submit">Acheter</button>
                                </form>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </section>

            <section class="section">
                <h2>Suggestions Activit&eacute;s</h2>

                <?php if (empty($activites)): ?>
                    <p class="muted">Aucune activit&eacute; disponible pour cet objectif.</p>
                <?php endif; ?>

                <?php foreach ($activites as $activite): ?>
                    <div class="item">
                        <strong><?= esc($activite['activite_nom']) ?></strong>
                        <p>
                            Fr&eacute;quence: <?= esc($activite['frequence_par_semaine']) ?> fois par semaine<br>
                            Dur&eacute;e: <?= esc($activite['duree_minutes_par_seance']) ?> minutes par s&eacute;ance<br>
                            Programme: <?= esc($activite['duree_jours']) ?> jours<br>
                            <a href="<?= site_url('activites/details/' . $activite['activite_id']) ?>">Voir les d&eacute;tails</a>
                        </p>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const objectifSelect = document.getElementById('objectif_id');
        const imcCibleField = document.getElementById('imc-cible-field');
        const imcCibleInput = document.getElementById('imc_cible');

        function toggleImcCible() {
            const selectedOption = objectifSelect.options[objectifSelect.selectedIndex];
            const showField = selectedOption && selectedOption.dataset.imc === '1';

            imcCibleField.classList.toggle('is-hidden', ! showField);
            imcCibleInput.required = showField;
        }

        if (objectifSelect && imcCibleField && imcCibleInput) {
            objectifSelect.addEventListener('change', toggleImcCible);
            toggleImcCible();
        }
    </script>
<?= $this->endSection() ?>
