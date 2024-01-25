<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>

<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | mission"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Add mission</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=mission&action=list">Mission list</a></li>
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
                    <label for="mission-codename" class="form-label">Code name :</label>
                    <input type="text" class="form-control" id="mission-codename" name="mission-codename"
                           value="" maxlength="30" aria-describedby="codename-help"
                           required>
                    <div id="codename-help" class="form-text text-light">Required. 30 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-title" class="form-label">Title :</label>
                    <input type="text" class="form-control" id="mission-title" name="mission-title"
                           value="" maxlength="80"
                           aria-describedby="title-help">
                    <div id="title-help" class="form-text text-light">Required. 80 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-description" class="form-label">Description :</label>
                    <textarea class="form-control" id="mission-description" name="mission-description" rows="8"
                              aria-describedby="description-help"></textarea>
                    <div id="description-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-country" class="form-label">Country :</label>
                    <input type="text" class="form-control" id="mission-country" name="mission-country"
                           value="" maxlength="50"
                           aria-describedby="country-help" required>
                    <div id="country-help" class="form-text text-light">Required. 50 characters max.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-type" class="form-label">Type :</label>
                    <select class="form-select" id="mission-type" name="mission-type"
                            aria-label="mission type" aria-describedby="type-help" required>
                        <?php foreach ($missionTypes as $type) : ?>
                            <option value="<?= $type->getId() ?>"><?= $type->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="type-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-specialty" class="form-label">Specialty :</label>
                    <select class="form-select" id="mission-specialty" name="mission-specialty"
                            aria-label="mission specialty" aria-describedby="specialty-help" required>
                        <?php foreach ($specialties as $specialty) : ?>
                            <option value="<?= $specialty->getId() ?>"><?= $specialty->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="specialty-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-status" class="form-label">Status :</label>
                    <select class="form-select" id="mission-status" name="mission-status"
                            aria-label="mission status" aria-describedby="status-help" required>
                        <?php foreach ($missionsStatus as $status) : ?>
                            <option value="<?= $status->getId() ?>"><?= $status->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="status-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-start-date" class="form-label">Start data :</label>
                    <input type="datetime-local" class="form-control" id="mission-start-date"
                           name="mission-start-date"
                           value="" aria-describedby="start-date-help" required>
                    <div id="start-date-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-end-date" class="form-label">End date :</label>
                    <input type="datetime-local" class="form-control" id="mission-end-date"
                           name="mission-end-date"
                           value="" aria-describedby="end-date-help" required>
                    <div id="end-date-help" class="form-text text-light">Required.</div>
                </div>
                <?php if (isset($hideouts)) : ?>
                    <div class="mb-3">
                        <label for="mission-hideouts" class="form-label">Hideout(s) :</label>
                        <select class="form-select" id="mission-hideouts" name="mission-hideouts[]" size="5"
                                multiple aria-label="mission hideouts" aria-describedby="hideouts-help">
                            <?php foreach ($hideouts as $hideout): ?>
                                <option value="<?= $hideout->getUUID() ?>"><?= $hideout->getCodename() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="hideouts-help" class="form-text text-light">Press
                            <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple hideouts.
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($contacts)) : ?>
                    <div class="mb-3">
                        <label for="mission-contacts" class="form-label">Contact(s) :</label>
                        <select class="form-select" id="mission-contacts" name="mission-contacts[]" size="5"
                                multiple aria-label="mission contacts" aria-describedby="contacts-help">
                            <?php foreach ($contacts as $contact): ?>
                                <option value="<?= $contact->getUUID() ?>"><?= $contact->getCodeName() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="contacts-help" class="form-text text-light">Required. Press
                            <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple contacts.
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($agents)) : ?>
                    <div class="mb-3">
                        <label for="mission-agents" class="form-label">Agent(s) :</label>
                        <select class="form-select" id="mission-agents" name="mission-agents[]" size="5"
                                multiple aria-label="mission agents" aria-describedby="agents-help">
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent->getUUID() ?>"><?= $agent->getCode() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="agents-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd>
                            or <kbd>Shift</kbd> to select multiple agents.
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($targets)) : ?>
                    <div class="mb-3">
                        <label for="mission-targets" class="form-label">Target(s) :</label>
                        <select class="form-select" id="mission-targets" name="mission-targets[]" size="5"
                                multiple aria-label="mission targets" aria-describedby="targets-help">
                            <?php foreach ($targets as $target): ?>
                                <option value="<?= $target->getUUID() ?>"><?= $target->getCodeName() ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="targets-help" class="form-text text-light">Required. Press
                            <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple targets.
                        </div>
                    </div>
                <?php endif ?>
                <div class="row justify-content-center my-4">
                    <div class="col-12">
                        <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                        <a href="?controller=mission&action=list" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
