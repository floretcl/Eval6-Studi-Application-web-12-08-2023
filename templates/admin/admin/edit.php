<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../../../assets/js/admin/admin.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | admin"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Edit admin</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=admin&action=list">Admin list</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <!-- ADMIN INTERFACE -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) : ?>
        <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
                <?php require(__DIR__ . '/../admin-message.php') ?>
                <div class="mb-3">
                    <label for="admin-uuid" class="form-label">UUID :</label>
                    <input type="text" class="form-control" id="admin-uuid" name="admin-uuid"
                           value="<?= htmlspecialchars($admin->getUUID()) ?>" maxlength="36" aria-describedby="uuid-help" readonly
                           required>
                    <div id="uuid-help" class="form-text text-light">Read only.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-firstname" class="form-label">Firstname :</label>
                    <input type="text" class="form-control" id="admin-firstname" name="admin-firstname"
                           value="<?= htmlspecialchars($admin->getFirstName()) ?>" maxlength="30"
                           aria-describedby="firstname-help">
                    <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-lastname" class="form-label">Lastname :</label>
                    <input type="text" class="form-control" id="admin-lastname" name="admin-lastname"
                           value="<?= htmlspecialchars($admin->getLastName()) ?>" maxlength="30" aria-describedby="lastname-help">
                    <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-email" class="form-label">Email :</label>
                    <input type="text" class="form-control" id="admin-email" name="admin-email"
                           value="<?= htmlspecialchars($admin->getEmail()) ?>" maxlength="254" aria-describedby="email-help"
                           required>
                    <div id="email-help" class="form-text text-light">Required. 254 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-password-hash" class="form-label">Password hash :</label>
                    <input type="text" class="form-control" id="admin-password-hash" name="admin-password-hash"
                           value="<?= htmlspecialchars($admin->getPasswordHash()) ?>" aria-describedby="password-hash-help"
                           readonly required>
                    <div id="password-hash-help" class="form-text text-light">Read only.</div>
                </div>
                <div class="mb-3">
                    <label for="admin-creation-date" class="form-label">Creation date :</label>
                    <input type="datetime-local" class="form-control" id="admin-creation-date"
                           name="admin-creation-date" value="<?= htmlspecialchars($admin->getCreationDate()) ?>"
                           aria-describedby="creation-date-help" readonly required>
                    <div id="creation-date-help" class="form-text text-light">Read only.</div>
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
                        <p>Do you really want to delete this admin?</p>
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
