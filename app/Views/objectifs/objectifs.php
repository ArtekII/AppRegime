<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix Objectif</title>
</head>
<body>
    <h1>Veuillez choisir votre objectif :</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (! empty($objectifs)): ?>
        <form action="<?= base_url('objectifs/submit') ?>" method="post">
            <?= csrf_field() ?>
            <?php if (! empty($utilisateurId)): ?>
                <input type="hidden" name="utilisateur_id" value="<?= esc($utilisateurId) ?>">
            <?php endif; ?>

            <select name="objectif" id="objectif" required>
                <option value="">-- S&eacute;lectionnez un objectif --</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option
                        value="<?= esc($objectif['id']) ?>"
                        data-imc="<?= stripos($objectif['type'], 'IMC') !== false ? '1' : '0' ?>"
                        <?= old('objectif') == $objectif['id'] ? 'selected' : '' ?>
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
                    value="<?= esc(old('imc_cible') ?? '22.0') ?>"
                >
            </p>

            <button type="submit">Faire mon choix</button>
        </form>
    <?php else: ?>
        <p>Aucun objectif disponible pour le moment.</p>
    <?php endif; ?>

    <script>
        const objectifSelect = document.getElementById('objectif');
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
