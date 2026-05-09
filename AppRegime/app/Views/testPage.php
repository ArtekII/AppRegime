<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenue dans la page principale <?php echo(session()->get('user_name'))  ?></h1>
    <?php var_dump(session()->get('isAdmin'))  ?>

    
     <h2>Votre solde: <?php echo(session()->get('solde'))  ?> €</h2>
    <h2><a href="<?= site_url('code') ?>">Aller vers le CRUD code</a></h2>
</body>
</html>