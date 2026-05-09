<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Inscription<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="auth-panel">
        <h1>Inscription</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif; ?>

        <div class="progress-wrap" aria-live="polite">
            <div class="progress-meta">
                <span id="step-label">Etape 1 sur 3</span>
                <strong id="progress-percent">33%</strong>
            </div>
            <div class="progress-bar" aria-hidden="true">
                <span id="progress-fill"></span>
            </div>
        </div>

        <ol class="steps">
            <li class="is-active" data-step-marker="1">Compte</li>
            <li data-step-marker="2">Profil</li>
            <li data-step-marker="3">Mesures</li>
        </ol>

        <form action="<?= base_url('save') ?>" method="post" id="register-form">
            <?= csrf_field() ?>

            <section class="step-panel" data-step="1">
                <h2>Compte</h2>
                <p>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" value="<?= esc(old('email')) ?>" required>
                </p>
                <p>
                    <label for="password">Mot de passe</label><br>
                    <input type="password" name="password" id="password" required>
                </p>
            </section>

            <section class="step-panel is-hidden" data-step="2">
                <h2>Profil</h2>
                <p>
                    <label for="nom">Nom</label><br>
                    <input type="text" name="nom" id="nom" value="<?= esc(old('nom')) ?>" required>
                </p>
                <fieldset class="inline-fieldset">
                    <legend>Genre</legend>
                    <label><input type="radio" name="genre" value="Homme" required> Homme</label>
                    <label><input type="radio" name="genre" value="Femme"> Femme</label>
                    <label><input type="radio" name="genre" value="Autre"> Autre</label>
                </fieldset>
            </section>

            <section class="step-panel is-hidden" data-step="3">
                <h2>Mesures</h2>
                <p>
                    <label for="taille">Taille (cm)</label><br>
                    <input type="number" step="0.1" name="taille" id="taille" value="<?= esc(old('taille')) ?>" required>
                </p>
                <p>
                    <label for="poids">Poids (kg)</label><br>
                    <input type="number" step="0.1" name="poids" id="poids" value="<?= esc(old('poids')) ?>" required>
                </p>
            </section>

            <div class="step-actions">
                <button type="button" id="previous-step">Precedent</button>
                <button type="button" id="next-step">Suivant</button>
                <button type="submit" id="submit-register" class="is-hidden">Terminer l'inscription</button>
            </div>
        </form>

        <p class="muted">
            Deja inscrit ?
            <a href="<?= site_url('connexion') ?>">Se connecter</a>
        </p>
    </section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        const panels = Array.from(document.querySelectorAll('[data-step]'));
        const markers = Array.from(document.querySelectorAll('[data-step-marker]'));
        const previousButton = document.getElementById('previous-step');
        const nextButton = document.getElementById('next-step');
        const submitButton = document.getElementById('submit-register');
        const progressFill = document.getElementById('progress-fill');
        const progressPercent = document.getElementById('progress-percent');
        const stepLabel = document.getElementById('step-label');
        let currentStep = 1;

        function currentPanelFields() {
            const panel = document.querySelector(`[data-step="${currentStep}"]`);
            return Array.from(panel.querySelectorAll('input, select, textarea'));
        }

        function canLeaveStep() {
            return currentPanelFields().every((field) => field.reportValidity());
        }

        function renderStep() {
            const total = panels.length;
            const percent = Math.round((currentStep / total) * 100);

            panels.forEach((panel) => {
                panel.classList.toggle('is-hidden', Number(panel.dataset.step) !== currentStep);
            });

            markers.forEach((marker) => {
                marker.classList.toggle('is-active', Number(marker.dataset.stepMarker) === currentStep);
                marker.classList.toggle('is-complete', Number(marker.dataset.stepMarker) < currentStep);
            });

            progressFill.style.width = `${percent}%`;
            progressPercent.textContent = `${percent}%`;
            stepLabel.textContent = `Etape ${currentStep} sur ${total}`;
            previousButton.disabled = currentStep === 1;
            nextButton.classList.toggle('is-hidden', currentStep === total);
            submitButton.classList.toggle('is-hidden', currentStep !== total);
        }

        previousButton.addEventListener('click', () => {
            currentStep = Math.max(1, currentStep - 1);
            renderStep();
        });

        nextButton.addEventListener('click', () => {
            if (! canLeaveStep()) {
                return;
            }

            currentStep = Math.min(panels.length, currentStep + 1);
            renderStep();
        });

        renderStep();
    </script>
<?= $this->endSection() ?>
