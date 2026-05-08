<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une activité</title>
</head>
<body>
    <?php $activite = $activite ?? []; ?>
    <h1>Modifier une activité sportive</h1>

    <form action="<?= base_url('activite/update/' . $activite['id']) ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= esc($activite['nom']) ?>" required>
        </p>

        <p>
            <label for="calories_brulees_par_heure">Calories brûlées par heure:</label>
            <input type="number" id="calories_brulees_par_heure" name="calories_brulees_par_heure" step="0.1" value="<?= $activite['calories_brulees_par_heure'] ?>" required>
        </p>

        <input type="submit" value="Mettre à jour">
        <a href="<?= base_url('activite') ?>"><button type="button">Annuler</button></a>
    </form>
</body>
</html>
