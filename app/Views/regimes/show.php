<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc((string)($regime['nom'] ?? '')) ?></title>
</head>
<body>
    <?php $regime = $regime ?? []; ?>
    <h1><?= esc((string)($regime['nom'] ?? '')) ?></h1>

    <p><strong>ID:</strong> <?= $regime['id'] ?></p>
    <p><strong>Variation de poids:</strong> <?= $regime['variation_poids'] ?> kg</p>
    <p><strong>Durée:</strong> <?= $regime['duree'] ?> jours</p>
    <p><strong>Prix:</strong> <?= $regime['prix'] ?> €</p>
    <p><strong>Pourcentage de viandes:</strong> <?= $regime['pourcentage_viandes'] ?>%</p>
    <p><strong>Pourcentage de poissons:</strong> <?= $regime['pourcentage_poissons'] ?>%</p>
    <p><strong>Pourcentage de volailles:</strong> <?= $regime['pourcentage_vollailes'] ?>%</p>
    <p><strong>Date de création:</strong> <?= $regime['date_creation'] ?></p>

    <a href="<?= base_url('regime/edit/' . $regime['id']) ?>"><button>Modifier</button></a>
    <a href="<?= base_url('regime/delete/' . $regime['id']) ?>" onclick="return confirm('Êtes-vous sûr?')"><button>Supprimer</button></a>
    <a href="<?= base_url('regime') ?>"><button>Retour</button></a>
</body>
</html>
