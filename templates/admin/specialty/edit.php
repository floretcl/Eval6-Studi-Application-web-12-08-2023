<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../../../assets/js/specialty/specialty.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | specialty"?>

<?php ob_start(); ?>
    <div class="container-fluid container-sm text-light">
        <div class="text-center my-5">
            <h1 class="text-uppercase font-monospace">Administration</h1>
            <h2 class="text-uppercase font-monospace">Edit specialty</h2>
        </div>
        <div>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                    <li class="breadcrumb-item"><a class="link-secondary" href="?controller=specialty&action=list">Specialty list</a></li>
                    <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
            <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
                <form action="" method="post">
                    <?php require(__DIR__ . '/../admin-message.php') ?>
                    <div class="mb-3">
                        <label for="specialty-id" class="form-label">Id :</label>
                        <input type="text" class="form-control" id="specialty-id" name="specialty-id"
                               value="<?= $specialty->getId() ?>" aria-describedby="specialty-id-help"
                               readonly required>
                        <div id="specialty-id-help" class="form-text text-light">Read only.</div>
                    </div>
                    <div class="mb-3">
                        <label for="specialty-name" class="form-label">Name :</label>
                        <input type="text" class="form-control" id="specialty-name" name="specialty-name"
                               value="<?= $specialty->getName() ?>" maxlength="50" aria-describedby="specialty-name-help"
                               required>
                        <div id="specialty-name-help" class="form-text text-light">Required. 50 characters max.</div>
                    </div>
                    <div class="row justify-content-center my-4">
                        <div class="col-12">
                            <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                            <button type="button" id="delete-button" class="btn btn-danger me-2"
                                    data-bs-toggle="modal" data-bs-target="#delete-modal">Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal text-dark" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Do you really want to delete this specialty?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    id="delete-confirm-btn">Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>

