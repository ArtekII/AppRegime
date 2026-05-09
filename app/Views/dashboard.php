<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('page_header') ?>
    <h1>Tableau de bord</h1>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php if (session()->getFlashdata('success')): ?>
        <p class="alert-success"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <section class="stat-grid" aria-label="Statistiques">
        <article class="stat-card">
            <span>Nombre total utilisateurs</span>
            <strong>128</strong>
        </article>
        <article class="stat-card">
            <span>Nombre abonnes Gold</span>
            <strong>42</strong>
        </article>
        <article class="stat-card">
            <span>Revenus totaux</span>
            <strong>8 450 000 Ar</strong>
        </article>
        <article class="stat-card">
            <span>Nombre regimes</span>
            <strong>18</strong>
        </article>
        <article class="stat-card">
            <span>Nombre activites sportives</span>
            <strong>24</strong>
        </article>
        <article class="stat-card">
            <span>Nombre codes utilises</span>
            <strong>76</strong>
        </article>
        <article class="stat-card">
            <span>Nombre objectifs actifs</span>
            <strong>93</strong>
        </article>
    </section>

    <section class="dashboard-charts">
        <article class="dashboard-card">
            <h2>Objectifs</h2>
            <div class="pie-chart" aria-label="Reduire poids 55%, IMC ideal 30%, Augmenter poids 15%"></div>
            <ul class="chart-legend">
                <li><span class="legend-dot reduce"></span>Reduire poids <strong>55%</strong></li>
                <li><span class="legend-dot imc"></span>IMC ideal <strong>30%</strong></li>
                <li><span class="legend-dot gain"></span>Augmenter poids <strong>15%</strong></li>
            </ul>
        </article>

        <article class="dashboard-card">
            <h2>Inscriptions</h2>
            <svg class="line-chart" viewBox="0 0 420 220" role="img" aria-label="Inscriptions par jour">
                <line x1="40" y1="180" x2="390" y2="180"></line>
                <line x1="40" y1="28" x2="40" y2="180"></line>
                <polyline points="40,132 155,84 270,156 385,60"></polyline>
                <circle cx="40" cy="132" r="4"></circle>
                <circle cx="155" cy="84" r="4"></circle>
                <circle cx="270" cy="156" r="4"></circle>
                <circle cx="385" cy="60" r="4"></circle>
                <text x="34" y="202">1 Mai</text>
                <text x="148" y="202">2 Mai</text>
                <text x="263" y="202">3 Mai</text>
                <text x="378" y="202">4 Mai</text>
                <text x="14" y="136">3</text>
                <text x="14" y="88">5</text>
                <text x="14" y="160">2</text>
                <text x="14" y="64">6</text>
            </svg>
            <table class="compact-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inscriptions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 Mai</td><td>3</td></tr>
                    <tr><td>2 Mai</td><td>5</td></tr>
                    <tr><td>3 Mai</td><td>2</td></tr>
                </tbody>
            </table>
        </article>
    </section>

    <section class="dashboard-card">
        <h2>Objectif x genre</h2>
        <table>
            <thead>
                <tr>
                    <th>Objectif</th>
                    <th>Homme</th>
                    <th>Femme</th>
                    <th>Autre</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Reduire poids</td>
                    <td>24</td>
                    <td>39</td>
                    <td>4</td>
                    <td>67</td>
                </tr>
                <tr>
                    <td>IMC ideal</td>
                    <td>14</td>
                    <td>20</td>
                    <td>3</td>
                    <td>37</td>
                </tr>
                <tr>
                    <td>Augmenter poids</td>
                    <td>17</td>
                    <td>6</td>
                    <td>1</td>
                    <td>24</td>
                </tr>
            </tbody>
        </table>
    </section>
<?= $this->endSection() ?>
