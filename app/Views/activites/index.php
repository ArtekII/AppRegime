<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités sportives</title>
</head>
<body>
    <?php $activites = $activites ?? []; ?>
    <h1>Gestion des Activités sportives</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <a href="<?= base_url('activite/create') ?>"><button>Ajouter une activité</button></a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Calories brûlées/heure</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($activites as $activite): ?>
                <tr>
                    <td><?= $activite['id'] ?></td>
                    <td><?= esc((string)($activite['nom'] ?? '')) ?></td>
                    <td><?= $activite['calories_brulees_par_heure'] ?></td>
                    <td><?= $activite['date_creation'] ?></td>
                    <td>
                        <a href="<?= base_url('activite/show/' . $activite['id']) ?>"><button>Voir</button></a>
                        <a href="<?= base_url('activite/edit/' . $activite['id']) ?>"><button>Modifier</button></a>
                        <a href="<?= base_url('activite/delete/' . $activite['id']) ?>" onclick="return confirm('Êtes-vous sûr?')"><button>Supprimer</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
