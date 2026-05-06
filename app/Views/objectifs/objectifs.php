<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix Objectif</title>
</head>
<body>
    <h1>Veuillez choisir votre objectif :</h1>
    <form action="/objectifs/submit" method="post">
        <select name="objectif" id="objectif">
            <?php foreach ($objectifs as $objectif): ?>
                <option value="<?= esc($objectif['id']) ?>"><?= esc($objectif['type']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Faire mon choix</button>
    </form>
</body>
</html>