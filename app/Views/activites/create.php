<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une activité</title>
</head>
<body>
    <h1>Créer une activité sportive</h1>

    <form action="<?= base_url('activite/store') ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </p>

        <p>
            <label for="calories_brulees_par_heure">Calories brûlées par heure:</label>
            <input type="number" id="calories_brulees_par_heure" name="calories_brulees_par_heure" step="0.1" required>
        </p>

        <input type="submit" value="Créer">
        <a href="<?= base_url('activite') ?>"><button type="button">Annuler</button></a>
    </form>
</body>
</html>
