<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Choix Objectif<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Veuillez choisir votre objectif :</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (! empty($objectifs)): ?>
        <form action="<?= base_url('objectifs/submit') ?>" method="post">
            <?= csrf_field() ?>
            <?php if (! empty($utilisateurId)): ?>
                <input type="hidden" name="utilisateur_id" value="<?= esc($utilisateurId) ?>">
            <?php endif; ?>

            <select name="objectif" id="objectif" required>
                <option value="">-- S&eacute;lectionnez un objectif --</option>
                <?php foreach ($objectifs as $objectif): ?>
                    <option
                        value="<?= esc($objectif['id']) ?>"
                        data-imc="<?= stripos($objectif['type'], 'IMC') !== false ? '1' : '0' ?>"
                        <?= old('objectif') == $objectif['id'] ? 'selected' : '' ?>
                    >
                        <?= esc($objectif['type']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p id="imc-cible-field" class="is-hidden">
                <label for="imc_cible">IMC cible souhait&eacute;</label>
                <input
                    type="number"
                    name="imc_cible"
                    id="imc_cible"
                    min="18.5"
                    max="24.9"
                    step="0.1"
                    value="<?= esc(old('imc_cible') ?? '22.0') ?>"
                >
            </p>

            <button type="submit">Faire mon choix</button>
        </form>
    <?php else: ?>
        <p>Aucun objectif disponible pour le moment.</p>
    <?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const objectifSelect = document.getElementById('objectif');
        const imcCibleField = document.getElementById('imc-cible-field');
        const imcCibleInput = document.getElementById('imc_cible');

        function toggleImcCible() {
            const selectedOption = objectifSelect.options[objectifSelect.selectedIndex];
            const showField = selectedOption && selectedOption.dataset.imc === '1';

            imcCibleField.classList.toggle('is-hidden', ! showField);
            imcCibleInput.required = showField;
        }

        if (objectifSelect && imcCibleField && imcCibleInput) {
            objectifSelect.addEventListener('change', toggleImcCible);
            toggleImcCible();
        }
    </script>
<?= $this->endSection() ?>
