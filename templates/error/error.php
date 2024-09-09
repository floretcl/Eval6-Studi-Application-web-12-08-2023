<?php $description = "KGB missions : Error, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | error"?>
<?php ob_start(); ?>
<div class="container text-light">
    <div class="row text-center my-5">
        <h1 class="text-uppercase font-monospace">Error</h1>
        <p class=""><?= $message ?></p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout.php') ?>
