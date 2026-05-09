<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Gestion des codes<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Gestion des codes</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul class="alert-error">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <section class="section">
        <h2>Cr&eacute;er un nouveau code</h2>
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
    </section>

    <section class="section">
        <h2>Codes disponibles</h2>
        <?php $codesDisponibles = array_filter($codes, static fn ($code) => ! (bool) $code['utilise']); ?>
        <?php if (! empty($codesDisponibles)): ?>
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
                    <?php foreach ($codesDisponibles as $code): ?>
                        <tr>
                            <td><?= esc($code['id']) ?></td>
                            <td><?= esc($code['code']) ?></td>
                            <td><?= number_format((float) $code['montant'], 2, ',', ' ') ?> EUR</td>
                            <td>
                                <form action="<?= base_url('code/use') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="code_id" value="<?= esc($code['id']) ?>">
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
    </section>

    <p><a href="<?= site_url('accueil') ?>">Retourner &agrave; l'accueil</a></p>
<?= $this->endSection() ?>
