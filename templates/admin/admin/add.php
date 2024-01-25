<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | admin"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Add admin</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=admin&action=list">Admin list</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- ADMIN INTERFACE -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) : ?>
        <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
                <?php require(__DIR__ . '/../admin-message.php') ?>
                <div class="mb-3">
                    <label for="admin-firstname" class="form-label">Firstname :</label>
                    <input type="text" class="form-control" id="admin-firstname" name="admin-firstname" value=""
                           maxlength="30" aria-describedby="firstname-help">
                    <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-lastname" class="form-label">Lastname :</label>
                    <input type="text" class="form-control" id="admin-lastname" name="admin-lastname" value=""
                           maxlength="30" aria-describedby="lastname-help">
                    <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="admin-email" name="admin-email" value=""
                           maxlength="254" aria-describedby="email-help" required>
                    <div id="email-help" class="form-text text-light">Required. 254 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="admin-password" name="admin-password"
                           value="" aria-describedby="password-help" required>
                    <div id="password-help" class="form-text text-light">Required</div>
                </div>
                <div class="row justify-content-center my-4">
                    <div class="col-12">
                        <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                        <a href="?controller=admin&action=list" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
