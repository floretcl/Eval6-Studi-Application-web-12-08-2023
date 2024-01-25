<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../../../assets/js/agent/agent.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | agent"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Edit agent</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=agent&action=list">Agent list</a></li>
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
                    <label for="agent-uuid" class="form-label">UUID :</label>
                    <input type="text" class="form-control" id="agent-uuid" name="agent-uuid"
                           value="<?= htmlspecialchars($agent->getUUID()) ?>" maxlength="36" aria-describedby="agent-uuid-help"
                           readonly required>
                    <div id="agent-uuid-help" class="form-text text-light">Read only.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-code" class="form-label">Code :</label>
                    <input type="text" class="form-control" id="agent-code" name="agent-code"
                           value="<?= htmlspecialchars($agent->getCode()) ?>" maxlength="6" aria-describedby="code-help"
                           required>
                    <div id="code-help" class="form-text text-light">Required. 6 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-firstname" class="form-label">Firstname :</label>
                    <input type="text" class="form-control" id="agent-firstname" name="agent-firstname"
                           value="<?= htmlspecialchars($agent->getFirstName()) ?>" maxlength="30"
                           aria-describedby="firstname-help">
                    <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-lastname" class="form-label">Lastname :</label>
                    <input type="text" class="form-control" id="agent-lastname" name="agent-lastname"
                           value="<?= htmlspecialchars($agent->getLastName()) ?>" maxlength="30"
                           aria-describedby="lastname-help">
                    <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-birthday" class="form-label">Birthday :</label>
                    <input type="date" class="form-control" id="agent-birthday" name="agent-birthday"
                           value="<?= $agent->getBirthday() ?>" aria-describedby="birthday-help" required>
                    <div id="birthday-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-nationality" class="form-label">Nationality :</label>
                    <input type="text" class="form-control" id="agent-nationality" name="agent-nationality"
                           value="<?= htmlspecialchars($agent->getNationality()) ?>" maxlength="50"
                           aria-describedby="nationality-help" required>
                    <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-specialties" class="form-label">Specialties :</label>
                    <select class="form-select" id="agent-specialties" name="agent-specialties[]" size="<?= count($specialties) ?>"
                            multiple aria-label="agent specialties" aria-describedby="specialties-help"
                            required>
                        <?php foreach ($specialties as $specialty) : ?>
                            <option value="<?= htmlspecialchars($specialty->getId()) ?>" <?= in_array($specialty->getName(), $agentSpecialties, true) ? "selected" : ""; ?>><?= htmlspecialchars($specialty->getName()) ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="specialties-help" class="form-text text-light">Required. At least one.</div>
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
                        <p>Do you really want to delete this agent?</p>
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
