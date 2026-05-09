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
            <strong><?= number_format((int) $stats['totalUsers'], 0, ',', ' ') ?></strong>
        </article>
        <article class="stat-card">
            <span>Nombre abonnes Gold</span>
            <strong><?= number_format((int) $stats['goldSubscribers'], 0, ',', ' ') ?></strong>
        </article>
        <article class="stat-card">
            <span>Revenus totaux</span>
            <strong><?= number_format((float) $stats['totalRevenue'], 2, ',', ' ') ?> Ar</strong>
        </article>
        <article class="stat-card">
            <span>Nombre regimes</span>
            <strong><?= number_format((int) $stats['totalRegimes'], 0, ',', ' ') ?></strong>
        </article>
        <article class="stat-card">
            <span>Nombre activites sportives</span>
            <strong><?= number_format((int) $stats['totalActivites'], 0, ',', ' ') ?></strong>
        </article>
        <article class="stat-card">
            <span>Nombre codes utilises</span>
            <strong><?= number_format((int) $stats['usedCodes'], 0, ',', ' ') ?></strong>
        </article>
        <article class="stat-card">
            <span>Nombre objectifs actifs</span>
            <strong><?= number_format((int) $stats['activeObjectifs'], 0, ',', ' ') ?></strong>
        </article>
    </section>

    <section class="dashboard-charts">
        <article class="dashboard-card">
            <h2>Objectifs</h2>
            <div class="pie-chart" style="background: <?= esc($pieGradient, 'attr') ?>" aria-label="Repartition des objectifs"></div>
            <ul class="chart-legend">
                <?php foreach ($objectifDistribution as $item): ?>
                    <li>
                        <span class="legend-dot <?= esc($item['class']) ?>"></span>
                        <?= esc($item['label']) ?>
                        <strong><?= number_format((float) $item['percent'], 1, ',', ' ') ?>%</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        </article>

        <article class="dashboard-card">
            <h2>Inscriptions</h2>
            <svg class="line-chart" viewBox="0 0 <?= esc($lineChart['width']) ?> <?= esc($lineChart['height']) ?>" role="img" aria-label="Inscriptions par jour">
                <line x1="<?= esc($lineChart['left']) ?>" y1="<?= esc($lineChart['bottom']) ?>" x2="<?= esc($lineChart['right']) ?>" y2="<?= esc($lineChart['bottom']) ?>"></line>
                <line x1="<?= esc($lineChart['left']) ?>" y1="<?= esc($lineChart['top']) ?>" x2="<?= esc($lineChart['left']) ?>" y2="<?= esc($lineChart['bottom']) ?>"></line>
                <?php if (! empty($lineChart['polyline'])): ?>
                    <polyline points="<?= esc($lineChart['polyline'], 'attr') ?>"></polyline>
                    <?php foreach ($lineChart['points'] as $point): ?>
                        <circle cx="<?= esc($point['x']) ?>" cy="<?= esc($point['y']) ?>" r="4"></circle>
                        <text x="<?= esc($point['x'] - 12) ?>" y="202"><?= esc($point['label']) ?></text>
                        <text x="<?= esc($point['x'] - 4) ?>" y="<?= esc($point['y'] - 10) ?>"><?= esc($point['count']) ?></text>
                    <?php endforeach; ?>
                <?php endif; ?>
            </svg>
            <table class="compact-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inscriptions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inscriptions)): ?>
                        <tr><td colspan="2">Aucune inscription disponible.</td></tr>
                    <?php endif; ?>

                    <?php foreach ($inscriptions as $inscription): ?>
                        <tr>
                            <td><?= esc($inscription['label']) ?></td>
                            <td><?= esc($inscription['count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
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
                <?php foreach ($objectifGenreRows as $row): ?>
                    <tr>
                        <td><?= esc($row['label']) ?></td>
                        <td><?= esc($row['Homme']) ?></td>
                        <td><?= esc($row['Femme']) ?></td>
                        <td><?= esc($row['Autre']) ?></td>
                        <td><?= esc($row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?= $this->endSection() ?>
