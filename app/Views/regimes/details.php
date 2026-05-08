<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&eacute;tail du r&eacute;gime</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
            color: #222;
        }

        .section {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 18px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border-bottom: 1px solid #eee;
            padding: 10px;
            text-align: left;
        }

        a {
            color: #1d4ed8;
        }
    </style>
</head>
<body>
    <p><a href="<?= previous_url() ?: site_url('suggestions') ?>">Retour</a></p>

    <h1><?= esc($regime['nom']) ?></h1>

    <section class="section">
        <h2>Composition</h2>
        <p>
            Viandes: <?= esc($regime['pourcentage_viandes']) ?>%<br>
            Poissons: <?= esc($regime['pourcentage_poissons']) ?>%<br>
            Volailles: <?= esc($regime['pourcentage_volailles']) ?>%
        </p>
    </section>

    <section class="section">
        <h2>Prix disponibles</h2>

        <?php if (empty($prixRegimes)): ?>
            <p>Aucun prix disponible pour ce r&eacute;gime.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Dur&eacute;e</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prixRegimes as $prixRegime): ?>
                        <tr>
                            <td><?= esc($prixRegime['duree_jours']) ?> jours</td>
                            <td><?= number_format((float) $prixRegime['prix'], 2, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</body>
</html>
