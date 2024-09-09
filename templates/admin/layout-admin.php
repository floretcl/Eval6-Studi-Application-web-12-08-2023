<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">

    <meta name="description" content="<?= $description ?>>" />

    <!-- BOOTSTRAP CSS, CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <!-- BOOTSTRAP JS, JS -->
    <script src="../../assets/bootstrap/js/bootstrap.bundle.js" defer></script>
    <?= $js ?>

    <title><?= $title ?></title>
</head>

<body>
<div class="d-flex flex-column justify-content-between min-vh-100 bg-dark">
    <?php require(__DIR__ . '/admin-header.php') ?>

    <main>
        <?= $content ?>
    </main>

    <?php require(__DIR__ . '/../footer.php') ?>
</div>
</body>

</html>