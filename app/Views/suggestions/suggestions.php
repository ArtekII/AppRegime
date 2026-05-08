<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions</title>
</head>
<body>
    <h1>Suggestions</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <form action="<?= base_url('suggestions') ?>" method="get">
        <select name="objectif_id" required>
            <option value="">-- Sélectionnez un objectif --</option>
            <?php foreach ($objectifs as $objectif): ?>
                <option value="<?= esc($objectif['id']) ?>" <?= (int) $objectifId === (int) $objectif['id'] ? 'selected' : '' ?>>
                    <?= esc($objectif['type']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Voir les suggestions</button>
    </form>

    <?php if ($objectifId > 0 && empty($suggestions)): ?>
        <p>Aucune suggestion disponible pour cet objectif.</p>
    <?php endif; ?>

    <?php if (! empty($suggestions)): ?>
        <ul>
            <?php foreach ($suggestions as $suggestion): ?>
                <li>
                    Régime: <?= esc($suggestion['regime_nom']) ?>
                    <?php if (! empty($suggestion['activite_nom'])): ?>
                        - Activité: <?= esc($suggestion['activite_nom']) ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
