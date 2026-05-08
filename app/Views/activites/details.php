<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&eacute;tail de l'activit&eacute;</title>
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

    <h1><?= esc($activite['nom']) ?></h1>

    <section class="section">
        <h2>Informations</h2>
        <p>
            Calories br&ucirc;l&eacute;es par heure: <?= esc($activite['calories_brulees_par_heure']) ?> kcal
        </p>
    </section>

    <section class="section">
        <h2>Programmes associ&eacute;s</h2>

        <?php if (empty($programmes)): ?>
            <p>Aucun programme disponible pour cette activit&eacute;.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Objectif</th>
                        <th>Dur&eacute;e</th>
                        <th>Fr&eacute;quence</th>
                        <th>S&eacute;ance</th>
                        <th>Calories/s&eacute;ance</th>
                        <th>Calories/semaine</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($programmes as $programme): ?>
                        <tr>
                            <td><?= esc($programme['objectif_type']) ?></td>
                            <td><?= esc($programme['duree_jours']) ?> jours</td>
                            <td><?= esc($programme['frequence_par_semaine']) ?> fois/semaine</td>
                            <td><?= esc($programme['duree_minutes_par_seance']) ?> minutes</td>
                            <td><?= number_format((float) $programme['calories_par_seance'], 0, ',', ' ') ?> kcal</td>
                            <td><?= number_format((float) $programme['calories_par_semaine'], 0, ',', ' ') ?> kcal</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</body>
</html>
