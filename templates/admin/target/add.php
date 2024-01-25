<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | target"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Add target</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=target&action=list">Target list</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <!-- ADMIN INTERFACE -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
                <?php require(__DIR__ . '/../admin-message.php') ?>
                <div class="mb-3">
                    <label for="target-code-name" class="form-label">Codename:</label>
                    <input type="text" class="form-control" id="target-code-name" name="target-code-name"
                           value="" maxlength="30" aria-describedby="code-name-help" required>
                    <div id="code-name-help" class="form-text text-light">Required. 30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="target-firstname" class="form-label">Firstname :</label>
                    <input type="text" class="form-control" id="target-firstname" name="target-firstname"
                           value="" maxlength="30" aria-describedby="firstname-help">
                    <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="target-lastname" class="form-label">Lastname :</label>
                    <input type="text" class="form-control" id="target-lastname" name="target-lastname" value=""
                           maxlength="30" aria-describedby="lastname-help">
                    <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="target-birthday" class="form-label">Birthday :</label>
                    <input type="date" class="form-control" id="target-birthday" name="target-birthday" value=""
                           aria-describedby="birthday-help" required>
                    <div id="birthday-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="target-nationality" class="form-label">Nationality :</label>
                    <input type="text" class="form-control" id="target-nationality" name="target-nationality"
                           value="" maxlength="50" aria-describedby="nationality-help" required>
                    <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
                </div>
                <div class="row justify-content-center my-4">
                    <div class="col-12">
                        <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                        <a href="?controller=target&action=list" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
