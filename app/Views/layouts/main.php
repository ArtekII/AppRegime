<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
</head>
<body>
    <?php if (session()->get('is_logged_in')): ?>
        <header class="site-header">
            <nav class="nav" aria-label="Navigation principale">
                <a class="nav-brand" href="<?= site_url('accueil') ?>">Brandy</a>
                <div class="nav-links">
                    <a href="<?= site_url('accueil') ?>">Accueil</a>
                    <a href="<?= site_url('suggestions') ?>">Suggestions</a>
                    <a href="<?= site_url('code/use') ?>">Utiliser un code</a>
                    <a href="<?= site_url('deconnexion') ?>">Deconnexion</a>
                </div>
            </nav>
        </header>
    <?php endif; ?>

    <main class="page">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
