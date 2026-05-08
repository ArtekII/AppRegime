<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Brandy - Étape 2</h1>
    <fieldset>
        <h2>Informations physiques</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif; ?>

        <form action="<?= base_url('save') ?>" method="post">
            <?= csrf_field() ?>
            
            <!-- Champs cachés pour conserver les données de la première page -->
            <input type="hidden" name="email" value="<?= esc($email) ?>">
            <input type="hidden" name="nom" value="<?= esc($nom) ?>">
            <input type="hidden" name="password" value="<?= esc($password) ?>">
            <input type="hidden" name="genre" value="<?= esc($genre) ?>">

            <p>Taille (en cm) <input type="number" name="taille" required></p>
            <p>Poids (en kg) <input type="number" step="0.1" name="poids" required></p>

            <input type="submit" value="Continuer vers le choix d'objectif">
        </form>
    </fieldset>
</body>
</html>
