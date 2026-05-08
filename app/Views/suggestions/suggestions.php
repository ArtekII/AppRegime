<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages D'accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
            color: #222;
        }

        form {
            margin-bottom: 28px;
        }

        select,
        button {
            padding: 8px 10px;
        }

        .suggestions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .profile {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 18px;
        }

        .section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 18px;
        }

        .section h2 {
            margin-top: 0;
        }

        .item {
            border-top: 1px solid #eee;
            padding: 12px 0;
        }

        .item:first-of-type {
            border-top: 0;
        }

        .muted {
            color: #666;
        }

        .indicator {
            display: inline-block;
            border-radius: 6px;
            margin-top: 10px;
            padding: 8px 10px;
        }

        .indicator-ok {
            background: #e6f6ea;
            color: #166534;
        }

        .indicator-progress {
            background: #fff7ed;
            color: #9a3412;
        }
    </style>
</head>
<body>
    <h1>Bienvenue! Nous avons des suggestions prête à être choisie.</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
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

        <p id="imc-cible-field" style="display: none;">
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
        <?php if (! empty($utilisateur) && $imc !== null): ?>
            <section class="profile">
                <h2>Votre profil</h2>
                <p>
                    <?= esc($utilisateur['nom']) ?><br>
                    Taille: <?= esc($utilisateur['taille']) ?> cm<br>
                    Poids: <?= esc($utilisateur['poids']) ?> kg<br>
                    IMC: <strong><?= esc($imc) ?></strong><br>
                    Statut: <?= esc($categorieImc) ?>
                    <?php if ($imcCible !== null && $poidsCible !== null): ?>
                        <br>IMC cible: <strong><?= esc($imcCible) ?></strong>
                        <br>Poids cible estime: <?= esc($poidsCible) ?> kg
                        <?php if ($imcIdealAtteint === true): ?>
                            <br><span class="indicator indicator-ok">IMC ideal atteint</span>
                        <?php elseif ($ecartImcCible !== null): ?>
                            <br><span class="indicator indicator-progress">Ecart avec l'IMC cible: <?= esc($ecartImcCible) ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
            </section>
        <?php endif; ?>

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
                                <?= number_format((float) $regime['prix'], 2, ',', ' ') ?> Ar
                            <?php else: ?>
                                non disponible
                            <?php endif; ?>
                            <br>
                            <a href="<?= site_url('regimes/details/' . $regime['regime_id']) ?>">Voir les d&eacute;tails</a>
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

    <script>
        const objectifSelect = document.getElementById('objectif_id');
        const imcCibleField = document.getElementById('imc-cible-field');
        const imcCibleInput = document.getElementById('imc_cible');

        function toggleImcCible() {
            const selectedOption = objectifSelect.options[objectifSelect.selectedIndex];
            const showField = selectedOption && selectedOption.dataset.imc === '1';

            imcCibleField.style.display = showField ? 'block' : 'none';
            imcCibleInput.required = showField;
        }

        objectifSelect.addEventListener('change', toggleImcCible);
        toggleImcCible();
    </script>
</body>
</html>
