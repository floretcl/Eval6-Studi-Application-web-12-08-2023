<?php $description = "KGB missions : mission detail, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | mission details"?>

<?php ob_start(); ?>
<div class="container text-light">
    <div class="row text-center my-5">
        <h1 class="text-uppercase font-monospace"><?= htmlspecialchars($mission->getCodeName()) ?></h1>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="/">Missions</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>
    <!-- MISSION CARD -->
    <div class="card pt-2 pb-4 mt-2 mb-5">
        <h2 class="card-header text-center mb-2">Mission</h2>
        <div class="card-body">
            <h3 class="text-center text-uppercase font-monospace mt-2 mb-3"><?= htmlspecialchars($mission->getTitle()) ?></h3>
            <p class="card-text text-center font-monospace mb-5"><?= htmlspecialchars($mission->getDescription()) ?></p>
            <div class="row">
                <div class="col-12 col-lg-6 mt-4">
                    <!-- MISSION DETAILS -->
                    <h4 class="mb-3 text-uppercase font-monospace">Mission information</h4>
                    <div class="card-text mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">Type :</span>
                                <span class="fw-bold font-monospace"><?= htmlspecialchars($mission->getType()) ?></span>
                            </li>
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">Required specialty :</span>
                                <span class="fw-bold font-monospace"><?= htmlspecialchars($mission->getSpecialty()) ?></span>
                            </li>
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">Country :</span>
                                <span class="fw-bold font-monospace"><?= htmlspecialchars($mission->getCountry()) ?></span>
                            </li>
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">Status :</span>
                                <span class="fw-bold font-monospace"><?= htmlspecialchars($mission->getStatus()) ?></span>
                            </li>
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">Start :</span>
                                <span class="fw-bold font-monospace"><?= $mission->getStartDateLong(); ?></span>
                            </li>
                            <li class="list-group-item px-0 px-sm-2 px-md-3">
                                <span class="mb-1">End :</span>
                                <span class="fw-bold font-monospace"><?= $mission->getEndDateLong(); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if (isset($hideouts) && $hideouts != []) : ?>
                    <div class="col-12 col-lg-6 mt-4">
                        <!-- MISSION HIDEOUTS -->
                        <h4 class="mb-3 text-uppercase font-monospace"><?= count($hideouts) > 1 ? count($hideouts) . ' Hideouts' : 'Hideout' ?></h4>
                        <div class="row">
                            <?php foreach ($hideouts as $hideout) : ?>
                                <div class="col-12 <?= count($hideouts) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Code name :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($hideout->getCodeName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Address :</span>
                                            <span class="fw-bold font-monospace mb-2">
                                              <?php foreach ($hideout->getAddressArray() as $addressLine) : ?>
                                                  <?= htmlspecialchars($addressLine) ?><br>
                                              <?php endforeach ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Country :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($hideout->getCountry()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Type :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($hideout->getType()) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($contacts)  && $contacts != []) : ?>
                    <div class="col-12 col-lg-6 mt-4">
                        <!-- MISSION CONTACTS -->
                        <h4 class="mb-3 text-uppercase font-monospace"><?= count($contacts) > 1 ? count($contacts) . ' Contacts' : 'Contact' ?></h4>
                        <div class="row">
                            <?php foreach ($contacts as $contact) : ?>
                                <div class="col-12 <?= count($contacts) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Code name :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($contact->getCodeName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Firstname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($contact->getFirstName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Lastname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($contact->getLastName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Age :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($contact->getAge()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Birthday :</span>
                                            <span class="fw-bold font-monospace"><?= $contact->getBirthday(); ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Nationality :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($contact->getNationality()) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($agents) && $agents != []) : ?>
                    <div class="col-12 col-lg-6 mt-4">
                        <!-- MISSION AGENTS -->
                        <h4 class="mb-3 text-uppercase font-monospace"><?= count($agents) > 1 ? count($agents) . ' Agents' : 'Agent' ?></h4>
                        <div class="row">
                            <?php foreach ($agents as $agent) : ?>
                                <div class="col-12 <?= count($agents) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Code :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($agent->getCode()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Firstname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($agent->getFirstName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Lastname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($agent->getLastName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Age :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($agent->getAge()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Birthday :</span>
                                            <span class="fw-bold font-monospace"><?= $agent->getBirthday(); ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Nationality :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($agent->getNationality()) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if (isset($targets)  && $targets != []) : ?>
                    <div class="col-12 col-lg-6 mt-4">
                        <!-- MISSION TARGETS -->
                        <h4 class="mb-3 text-uppercase font-monospace"><?= count($targets) > 1 ? count($targets) . ' Targets' : 'Target' ?></h4>
                        <div class="row">
                            <?php foreach ($targets as $target) : ?>
                                <div class="col-12 <?= count($targets) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Code name :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($target->getCodeName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Firstname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($target->getFirstName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Lastname :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($target->getLastName()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Age :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($target->getAge()) ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Birthday :</span>
                                            <span class="fw-bold font-monospace"><?= $target->getBirthday(); ?></span>
                                        </li>
                                        <li class="list-group-item px-0 px-sm-2 px-md-">
                                            <span class="mb-1">Nationality :</span>
                                            <span class="fw-bold font-monospace"><?= htmlspecialchars($target->getNationality()) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layout.php') ?>
