<?php $description = "KGB missions : login, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | login"?>

<?php ob_start(); ?>
<div class="container text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
    </div>
    <!-- LOGIN -->
    <div class="row justify-content-center">
        <div class="col-10 col-sm-9 col-md-7 col-lg-5">
            <form class="form" action="" method="post">
                <?php if (isset($message)) : ?>
                    <div class="alert <?= $message == 'Valid identifiers' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                        <?php if ($message == 'Valid identifiers') : ?>
                            <img src="../assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
                        <?php else : ?>
                            <img src="../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
                        <?php endif ?>
                        <div>
                            <?= htmlspecialchars($message) ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="mb-3">
                    <label class="form-label" for="login-form-email">Email</label>
                    <input class="form-control" type="email" name="login-form-email" id="login-form-email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="login-form-password">Password</label>
                    <input class="form-control" type="password" name="login-form-password" id="login-form-password" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-light my-4" type="submit" id="login-form-btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layout.php') ?>
