<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | agent"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Add agent</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=agent&action=list">Agent list</a>
                </li>
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
                    <label for="agent-code" class="form-label">Code :</label>
                    <input type="text" class="form-control" id="agent-code" name="agent-code" value=""
                           maxlength="6" aria-describedby="code-help" required>
                    <div id="code-help" class="form-text text-light">Required. 6 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-firstname" class="form-label">Firstname :</label>
                    <input type="text" class="form-control" id="agent-firstname" name="agent-firstname" value=""
                           maxlength="30" aria-describedby="firstname-help">
                    <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-lastname" class="form-label">Lastname :</label>
                    <input type="text" class="form-control" id="agent-lastname" name="agent-lastname" value=""
                           maxlength="30" aria-describedby="lastname-help">
                    <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-birthday" class="form-label">Birthday :</label>
                    <input type="date" class="form-control" id="agent-birthday" name="agent-birthday" value=""
                           aria-describedby="birthday-help" required>
                    <div id="birthday-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-nationality" class="form-label">Nationality :</label>
                    <input type="text" class="form-control" id="agent-nationality" name="agent-nationality"
                           value="" maxlength="50" aria-describedby="nationality-help" required>
                    <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="agent-specialties" class="form-label">Specialties :</label>
                    <select class="form-select" id="agent-specialties" name="agent-specialties[]"
                            size="<?= count($specialties) ?>" multiple aria-label="agent specialties"
                            aria-describedby="specialties-help" required>
                        <?php foreach ($specialties as $specialty) : ?>
                            <option value="<?= htmlspecialchars($specialty->getId()) ?>"><?= htmlspecialchars($specialty->getName()) ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="specialties-help" class="form-text text-light">Required. Press
                        <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple specialties.
                    </div>
                </div>
                <div class="row justify-content-center my-4">
                    <div class="col-12">
                        <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                        <a href="?controller=agent&action=list" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
