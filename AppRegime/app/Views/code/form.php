<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Code</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ccc; padding: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        button { padding: 8px 12px; cursor: pointer; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Gestion des Codes</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul class="error">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Section Création de Code -->
    <div class="section">
        <h2>Créer un nouveau code</h2>
        <form action="<?= base_url('code/store') ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="code">Code</label><br>
                <input
                    type="text"
                    id="code"
                    name="code"
                    minlength="3"
                    maxlength="50"
                    value="<?= old('code') ?>"
                    required
                >
            </p>

            <p>
                <label for="montant">Montant</label><br>
                <input
                    type="number"
                    id="montant"
                    name="montant"
                    step="0.01"
                    min="0.01"
                    value="<?= old('montant') ?>"
                    required
                >
            </p>

            <button type="submit">Enregistrer</button>
        </form>
    </div>

    <!-- Section Utilisation des Codes -->
    <div class="section">
        <h2>Codes disponibles</h2>
        <?php $codes_dispos = array_filter($codes, fn($c) => !$c['utilise']); ?>
        <?php if (!empty($codes_dispos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($codes_dispos as $code): ?>
                        <tr>
                            <td><?= $code['id'] ?></td>
                            <td><?= esc($code['code']) ?></td>
                            <td><?= $code['montant'] ?> €</td>
                            <td>
                                <form action="<?= base_url('code/use') ?>" method="post" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="code_id" value="<?= $code['id'] ?>">
                                    <button type="submit">Utiliser</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun code disponible.</p>
        <?php endif; ?>
    </div>

    <p>
        <a href="<?= site_url('mainPage') ?>">Retournez à la page principale</a>
    </p>
</body>
</html>