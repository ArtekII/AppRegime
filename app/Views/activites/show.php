<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc((string)($activite['nom'] ?? '')) ?></title>
</head>
<body>
    <?php $activite = $activite ?? []; ?>
    <h1><?= esc((string)($activite['nom'] ?? '')) ?></h1>

    <p><strong>ID:</strong> <?= $activite['id'] ?></p>
    <p><strong>Calories brûlées par heure:</strong> <?= $activite['calories_brulees_par_heure'] ?></p>
    <p><strong>Date de création:</strong> <?= $activite['date_creation'] ?></p>

    <a href="<?= base_url('activite/edit/' . $activite['id']) ?>"><button>Modifier</button></a>
    <a href="<?= base_url('activite/delete/' . $activite['id']) ?>" onclick="return confirm('Êtes-vous sûr?')"><button>Supprimer</button></a>
    <a href="<?= base_url('activite') ?>"><button>Retour</button></a>
</body>
</html>
