<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Gestion des codes<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Gestion des codes</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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

    <section class="dashboard-card">
        <h2>Creer un nouveau code</h2>
        <form action="<?= site_url('code/store') ?>" method="post" class="settings-form-row">
            <?= csrf_field() ?>

            <p>
                <label for="code">Code</label><br>
                <input
                    type="text"
                    id="code"
                    name="code"
                    minlength="3"
                    maxlength="50"
                    value="<?= esc(old('code')) ?>"
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
                    value="<?= esc(old('montant')) ?>"
                    required
                >
            </p>

            <p class="settings-submit"><button type="submit">Enregistrer</button></p>
        </form>
    </section>

    <section class="dashboard-card">
        <h2>Codes existants</h2>

        <?php if (empty($codes)): ?>
            <p>Aucun code enregistre.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Actions admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($codes as $code): ?>
                        <form id="code-form-<?= esc($code['id']) ?>" action="<?= site_url('code/update/' . $code['id']) ?>" method="post">
                            <?= csrf_field() ?>
                        </form>
                        <tr>
                            <td><?= esc($code['id']) ?></td>
                            <td>
                                <input
                                    form="code-form-<?= esc($code['id']) ?>"
                                    type="text"
                                    name="code"
                                    minlength="3"
                                    maxlength="50"
                                    value="<?= esc($code['code']) ?>"
                                    required
                                >
                            </td>
                            <td>
                                <input
                                    form="code-form-<?= esc($code['id']) ?>"
                                    type="number"
                                    name="montant"
                                    step="0.01"
                                    min="0.01"
                                    value="<?= esc($code['montant']) ?>"
                                    required
                                >
                            </td>
                            <td>
                                <label class="code-status">
                                    <input
                                        form="code-form-<?= esc($code['id']) ?>"
                                        type="checkbox"
                                        name="utilise"
                                        value="1"
                                        <?= ! empty($code['utilise']) ? 'checked' : '' ?>
                                    >
                                    Utilise
                                </label>
                            </td>
                            <td>
                                <span class="code-actions">
                                    <button form="code-form-<?= esc($code['id']) ?>" type="submit">Modifier</button>
                                    <a href="<?= site_url('code/delete/' . $code['id']) ?>" onclick="return confirm('Supprimer ce code ?')">Supprimer</a>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>
