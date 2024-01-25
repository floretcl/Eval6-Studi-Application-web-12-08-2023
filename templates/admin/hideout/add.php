<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | hideout"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Add hideout</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=hideout&action=list">Hideout list</a></li>
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
                    <label for="hideout-code-name" class="form-label">Codename:</label>
                    <input type="text" class="form-control" id="hideout-code-name" name="hideout-code-name"
                           value="" maxlength="30" aria-describedby="code-name-help" required>
                    <div id="code-name-help" class="form-text text-light">Required. 30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="hideout-address" class="form-label">Address :</label>
                    <input type="text" class="form-control" id="hideout-address" name="hideout-address" value=""
                           maxlength="255" aria-describedby="address-help" required>
                    <div id="address-help" class="form-text text-light">255 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="hideout-country" class="form-label">Country :</label>
                    <input type="text" class="form-control" id="hideout-country" name="hideout-country" value=""
                           maxlength="50" aria-describedby="country-help" required>
                    <div id="country-help" class="form-text text-light">50 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="hideout-type" class="form-label">Type :</label>
                    <select class="form-select" id="hideout-type" name="hideout-type"
                            aria-label="hideout type" aria-describedby="type-help" required>
                        <?php foreach ($hideoutTypes as $type) : ?>
                            <option value="<?= $type->getId() ?>"><?= $type->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="type-help" class="form-text text-light">Required.</div>
                </div>
                <div class="row justify-content-center my-4">
                    <div class="col-12">
                        <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                        <a href="?controller=hideout&action=list" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
