<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body class="dashboard-body">
    <?php $currentPath = trim(service('uri')->getPath(), '/'); ?>
    <aside class="dashboard-sidebar">
        <a class="dashboard-brand" href="<?= site_url('dashboard') ?>">Brandy Admin</a>
        <nav class="dashboard-nav" aria-label="Navigation admin">
            <a class="<?= $currentPath === 'dashboard' ? 'is-active' : '' ?>" href="<?= site_url('dashboard') ?>">Tableau de bord</a>
            <a class="<?= $currentPath === 'code' ? 'is-active' : '' ?>" href="<?= site_url('code') ?>">Gestion des codes</a>
            <a href="#">Gestion des regimes</a>
            <a href="#">Gestion des activites sportif</a>
            <a href="#">Gestion des parametres</a>
        </nav>
        <a class="dashboard-logout" href="<?= site_url('deconnexion') ?>">Deconnexion</a>
    </aside>

    <main class="dashboard-main">
        <header class="dashboard-header">
            <div>
                <p class="muted">Administration</p>
                <?= $this->renderSection('page_header') ?>
            </div>
            <strong><?= esc(session()->get('user_name') ?? 'Admin') ?></strong>
        </header>

        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
