<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un régime</title>
</head>
<body>
    <?php $regime = $regime ?? []; ?>
    <h1>Modifier un régime</h1>

    <form action="<?= base_url('regime/update/' . $regime['id']) ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= esc($regime['nom']) ?>" required>
        </p>

        <p>
            <label for="variation_poids">Variation de poids (kg):</label>
            <input type="number" id="variation_poids" name="variation_poids" step="0.1" value="<?= $regime['variation_poids'] ?>" required>
        </p>

        <p>
            <label for="duree">Durée (jours):</label>
            <input type="number" id="duree" name="duree" value="<?= $regime['duree'] ?>" required>
        </p>

        <p>
            <label for="prix">Prix (€):</label>
            <input type="number" id="prix" name="prix" step="0.01" value="<?= $regime['prix'] ?>" required>
        </p>

        <p>
            <label for="pourcentage_viandes">Pourcentage de viandes (%):</label>
            <input type="number" id="pourcentage_viandes" name="pourcentage_viandes" step="0.1" min="0" max="100" value="<?= $regime['pourcentage_viandes'] ?>" required>
        </p>

        <p>
            <label for="pourcentage_poissons">Pourcentage de poissons (%):</label>
            <input type="number" id="pourcentage_poissons" name="pourcentage_poissons" step="0.1" min="0" max="100" value="<?= $regime['pourcentage_poissons'] ?>" required>
        </p>

        <p>
            <label for="pourcentage_vollailes">Pourcentage de volailles (%):</label>
            <input type="number" id="pourcentage_vollailes" name="pourcentage_vollailes" step="0.1" min="0" max="100" value="<?= $regime['pourcentage_vollailes'] ?>" required>
        </p>

        <input type="submit" value="Mettre à jour">
        <a href="<?= base_url('regime') ?>"><button type="button">Annuler</button></a>
    </form>
</body>
</html>
