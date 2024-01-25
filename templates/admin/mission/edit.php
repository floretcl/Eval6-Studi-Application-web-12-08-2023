<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../../../assets/js/mission/mission.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | mission"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Edit mission</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=mission&action=list">Mission list</a></li>
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
                    <label for="mission-uuid" class="form-label">UUID :</label>
                    <input type="text" class="form-control" id="mission-uuid" name="mission-uuid"
                           value="<?= $mission->getUUID() ?>" maxlength="36" aria-describedby="mission-uuid-help"
                           readonly required>
                    <div id="mission-uuid-help" class="form-text text-light">Read only.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-codename" class="form-label">Code name :</label>
                    <input type="text" class="form-control" id="mission-codename" name="mission-codename"
                           value="<?= $mission->getCodeName() ?>" maxlength="30" aria-describedby="codename-help"
                           required>
                    <div id="codename-help" class="form-text text-light">Required. 30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-title" class="form-label">Title :</label>
                    <input type="text" class="form-control" id="mission-title" name="mission-title"
                           value="<?= $mission->getTitle() ?>" maxlength="80"
                           aria-describedby="title-help">
                    <div id="title-help" class="form-text text-light">Required. 80 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-description" class="form-label">Description :</label>
                    <textarea class="form-control" id="mission-description" name="mission-description" rows="8"
                              aria-describedby="description-help"><?= $mission->getDescription() ?></textarea>
                    <div id="description-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-country" class="form-label">Country :</label>
                    <input type="text" class="form-control" id="mission-country" name="mission-country"
                           value="<?= $mission->getCountry() ?>" maxlength="50"
                           aria-describedby="country-help" required>
                    <div id="country-help" class="form-text text-light">Required. 50 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-type" class="form-label">Type :</label>
                    <select class="form-select" id="mission-type" name="mission-type"
                            aria-label="mission type" aria-describedby="type-help" required>
                        <?php foreach ($missionTypes as $type) : ?>
                            <option value="<?= $type->getId() ?>" <?= $mission->getType() == $type->getName() ? 'selected' : '' ?>><?= $type->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="type-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-specialty" class="form-label">Specialty :</label>
                    <select class="form-select" id="mission-specialty" name="mission-specialty"
                            aria-label="mission specialty" aria-describedby="specialty-help" required>
                        <?php foreach ($specialties as $specialty) : ?>
                            <option value="<?= $specialty->getId() ?>" <?= $mission->getSpecialty() == $specialty->getName() ? 'selected' : '' ?>><?= $specialty->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="specialty-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-status" class="form-label">Status :</label>
                    <select class="form-select" id="mission-status" name="mission-status"
                            aria-label="mission status" aria-describedby="status-help" required>
                        <?php foreach ($missionsStatus as $status) : ?>
                            <option value="<?= $status->getId() ?>" <?= $mission->getStatus() == $status->getName() ? 'selected' : '' ?>><?= $status->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="status-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-start-date" class="form-label">Start data :</label>
                    <input type="datetime-local" class="form-control" id="mission-start-date" name="mission-start-date"
                           value="<?= $mission->getStartDate() ?>" aria-describedby="start-date-help" required>
                    <div id="start-date-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-end-date" class="form-label">End date :</label>
                    <input type="datetime-local" class="form-control" id="mission-end-date" name="mission-end-date"
                           value="<?= $mission->getEndDate() ?>" aria-describedby="end-date-help" required>
                    <div id="end-date-help" class="form-text text-light">Required.</div>
                </div>
                <?php if (isset($hideouts)) : ?>
                    <div class="mb-3">
                        <label for="mission-hideouts" class="form-label">Hideout(s) :</label>
                        <select class="form-select" id="mission-hideouts" name="mission-hideouts[]" size="5"
                                multiple aria-label="mission hideouts" aria-describedby="hideouts-help">
                            <?php foreach ($hideouts as $hideout): ?>
                                <option value="<?= $hideout->getUUID() ?>" <?= in_array($hideout->getUUID(), $missionHideouts, true) ? "selected" : ""; ?>><?= $hideout->getCodename() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="hideouts-help" class="form-text text-light">Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple hideouts.</div>
                    </div>
                <?php endif ?>
                <?php if (isset($contacts)) : ?>
                    <div class="mb-3">
                        <label for="mission-contacts" class="form-label">Contact(s) :</label>
                        <select class="form-select" id="mission-contacts" name="mission-contacts[]" size="5"
                                multiple aria-label="mission contacts" aria-describedby="contacts-help">
                            <?php foreach ($contacts as $contact): ?>
                                <option value="<?= $contact->getUUID() ?>" <?= in_array($contact->getUUID(), $missionContacts, true) ? "selected" : ""; ?>><?= $contact->getCodeName() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="contacts-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple contacts.</div>
                    </div>
                <?php endif ?>
                <?php if (isset($agents)) : ?>
                    <div class="mb-3">
                        <label for="mission-agents" class="form-label">Agent(s) :</label>
                        <select class="form-select" id="mission-agents" name="mission-agents[]" size="5"
                                multiple aria-label="mission agents" aria-describedby="agents-help">
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent->getUUID() ?>" <?= in_array($agent->getUUID(), $missionAgents, true) ? "selected" : ""; ?>><?= $agent->getCode() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="agents-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple agents.</div>
                    </div>
                <?php endif ?>
                <?php if (isset($targets)) : ?>
                    <div class="mb-3">
                        <label for="mission-targets" class="form-label">Target(s) :</label>
                        <select class="form-select" id="mission-targets" name="mission-targets[]" size="5"
                                multiple aria-label="mission targets" aria-describedby="targets-help">
                            <?php foreach ($targets as $target): ?>
                                <option value="<?= $target->getUUID() ?>" <?= in_array($target->getUUID(), $missionTargets, true) ? "selected" : ""; ?>><?= $target->getCodeName() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="targets-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple targets.</div>
                    </div>
                <?php endif ?>
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
                        <p>Do you really want to delete this mission?</p>
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
