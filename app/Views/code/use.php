<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Utiliser un code<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Utiliser un code</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <section class="section">
        <h2>Codes disponibles</h2>
        <?php if (! empty($codes)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($codes as $code): ?>
                        <tr>
                            <td><?= esc($code['code']) ?></td>
                            <td><?= number_format((float) $code['montant'], 2, ',', ' ') ?> Ar</td>
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
            <p>Aucun code disponible pour le moment.</p>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>
