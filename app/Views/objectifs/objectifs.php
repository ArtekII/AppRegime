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
                <option value="">-- Sélectionnez un objectif --</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option value="<?= esc($objectif['id']) ?>" <?= old('objectif') == $objectif['id'] ? 'selected' : '' ?>>
                        <?= esc($objectif['type']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Faire mon choix</button>
        </form>
    <?php else: ?>
        <p>Aucun objectif disponible pour le moment.</p>
    <?php endif; ?>
</body>
</html>
