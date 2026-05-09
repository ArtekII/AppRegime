<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Gestion des parametres<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Gestion des parametres</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="alert-error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <section class="settings-grid">
        <article class="dashboard-card">
            <h2>Prix du Gold</h2>
            <form action="<?= site_url('parametres/gold') ?>" method="post">
                <?= csrf_field() ?>
                <p>
                    <label for="prix_gold">Prix actuel</label><br>
                    <input type="number" id="prix_gold" name="prix_gold" step="0.01" min="0.01" value="<?= esc($prixGold) ?>" required>
                </p>
                <button type="submit">Enregistrer</button>
            </form>
        </article>

        <article class="dashboard-card">
            <h2>Objectifs</h2>
            <form action="<?= site_url('parametres/objectif') ?>" method="post">
                <?= csrf_field() ?>
                <p>
                    <label for="objectif_type">Ajouter un objectif</label><br>
                    <select id="objectif_type" name="type" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($objectifTypes as $type): ?>
                            <option value="<?= esc($type) ?>"><?= esc($type) ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <button type="submit">Ajouter</button>
            </form>

            <table class="compact-table">
                <thead>
                    <tr>
                        <th>Objectif</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($objectifs)): ?>
                        <tr><td colspan="2">Aucun objectif.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($objectifs as $objectif): ?>
                        <tr>
                            <td><?= esc($objectif['type']) ?></td>
                            <td>
                                <a href="<?= site_url('parametres/objectif/delete/' . $objectif['id']) ?>" onclick="return confirm('Supprimer cet objectif ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </article>
    </section>

    <section class="dashboard-card">
        <h2>Variation du prix selon la duree</h2>
        <form action="<?= site_url('parametres/prix-regime') ?>" method="post" class="settings-form-row">
            <?= csrf_field() ?>
            <p>
                <label for="prix_regime_id">Regime</label><br>
                <select id="prix_regime_id" name="regime_id" required>
                    <option value="">-- Regime --</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= esc($regime['id']) ?>"><?= esc($regime['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="prix_duree">Duree</label><br>
                <input type="number" id="prix_duree" name="duree_jours" min="1" required>
            </p>
            <p>
                <label for="prix">Prix</label><br>
                <input type="number" id="prix" name="prix" step="0.01" min="0.01" required>
            </p>
            <p class="settings-submit"><button type="submit">Ajouter</button></p>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Regime</th>
                    <th>Duree</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($prixRegimes)): ?>
                    <tr><td colspan="4">Aucun prix configure.</td></tr>
                <?php endif; ?>
                <?php foreach ($prixRegimes as $prixRegime): ?>
                    <tr>
                        <td><?= esc($prixRegime['regime_nom']) ?></td>
                        <td><?= esc($prixRegime['duree_jours']) ?> jours</td>
                        <td><?= number_format((float) $prixRegime['prix'], 2, ',', ' ') ?> Ar</td>
                        <td>
                            <a href="<?= site_url('parametres/prix-regime/delete/' . $prixRegime['id']) ?>" onclick="return confirm('Supprimer ce prix ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="dashboard-card">
        <h2>Effets des regimes</h2>
        <form action="<?= site_url('parametres/effet-regime') ?>" method="post" class="settings-form-row">
            <?= csrf_field() ?>
            <p>
                <label for="effet_regime_id">Regime</label><br>
                <select id="effet_regime_id" name="regime_id" required>
                    <option value="">-- Regime --</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= esc($regime['id']) ?>"><?= esc($regime['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="effet_objectif_id">Objectif</label><br>
                <select id="effet_objectif_id" name="objectif_id" required>
                    <option value="">-- Objectif --</option>
                    <?php foreach ($objectifs as $objectif): ?>
                        <option value="<?= esc($objectif['id']) ?>"><?= esc($objectif['type']) ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="poids_min">Poids min</label><br>
                <input type="number" id="poids_min" name="poids_min" step="0.1" required>
            </p>
            <p>
                <label for="poids_max">Poids max</label><br>
                <input type="number" id="poids_max" name="poids_max" step="0.1" required>
            </p>
            <p>
                <label for="effet_duree">Duree</label><br>
                <input type="number" id="effet_duree" name="duree_jours" min="1" required>
            </p>
            <p class="settings-submit"><button type="submit">Ajouter</button></p>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Regime</th>
                    <th>Objectif</th>
                    <th>Poids cible</th>
                    <th>Duree</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($effetsRegimes)): ?>
                    <tr><td colspan="5">Aucun effet configure.</td></tr>
                <?php endif; ?>
                <?php foreach ($effetsRegimes as $effet): ?>
                    <tr>
                        <td><?= esc($effet['regime_nom']) ?></td>
                        <td><?= esc($effet['objectif_type']) ?></td>
                        <td><?= esc($effet['poids_min']) ?> kg a <?= esc($effet['poids_max']) ?> kg</td>
                        <td><?= esc($effet['duree_jours']) ?> jours</td>
                        <td>
                            <a href="<?= site_url('parametres/effet-regime/delete/' . $effet['id']) ?>" onclick="return confirm('Supprimer cet effet ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?= $this->endSection() ?>
