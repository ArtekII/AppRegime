<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Régimes</title>
</head>
<body>
    <?php $regimes = $regimes ?? []; ?>
    <h1>Gestion des Régimes</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <a href="<?= base_url('regime/create') ?>"><button>Ajouter un régime</button></a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Variation de poids</th>
                <th>Durée (jours)</th>
                <th>Prix</th>
                <th>Viandes (%)</th>
                <th>Poissons (%)</th>
                <th>Volailles (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($regimes as $regime): ?>
                <tr>
                    <td><?= $regime['id'] ?></td>
                    <td><?= esc((string)($regime['nom'] ?? '')) ?></td>
                    <td><?= $regime['variation_poids'] ?> kg</td>
                    <td><?= $regime['duree'] ?></td>
                    <td><?= $regime['prix'] ?> €</td>
                    <td><?= $regime['pourcentage_viandes'] ?>%</td>
                    <td><?= $regime['pourcentage_poissons'] ?>%</td>
                    <td><?= $regime['pourcentage_vollailes'] ?>%</td>
                    <td>
                        <a href="<?= base_url('regime/show/' . $regime['id']) ?>"><button>Voir</button></a>
                        <a href="<?= base_url('regime/edit/' . $regime['id']) ?>"><button>Modifier</button></a>
                        <a href="<?= base_url('regime/delete/' . $regime['id']) ?>" onclick="return confirm('Êtes-vous sûr?')"><button>Supprimer</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
