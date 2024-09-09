<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration"?>

<?php ob_start(); ?>
<div class="container text-light">
    <div class="row text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
    </div>
    <!-- ADMIN INTERFACE -->
    <div class="row justify-content-center mb-3">
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) : ?>
            <div class="d-flex align-items-start justify-content-center">
                <div class="nav nav-pills flex-column me-4 d-none d-lg-flex" id="admin-tab" role="tablist">
                    <button class="nav-link link-dark active" id="home-admin-tab" data-bs-toggle="pill" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                </div>
                <div class="flex-fill tab-content overflow-x-scroll px-3" id="admin-tab-content">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-admin-tab" tabindex="0">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Admins
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbAdmins) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=admin&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=admin&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Missions
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbMissions) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=mission&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=mission&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Hideouts
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbHideouts) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=hideout&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=hideout&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Agents
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbAgents) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=agent&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=agent&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Contacts
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbContacts) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=contact&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=contact&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Targets
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbTargets) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=target&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=target&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Mission types
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbMissionTypes) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=mission-type&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=mission-type&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Mission status
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbMissionStatus) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=mission-status&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=mission-status&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Hideout types
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbHideoutTypes) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=hideout-type&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=hideout-type&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                                    Specialties
                                    <span class="badge bg-primary rounded-pill ms-1"><?= htmlspecialchars($nbSpecialties) ?></span>
                                </div>
                                <div class="d-flex flex-nowrap">
                                    <a href="?controller=specialty&action=add" class="btn btn-dark btn-sm">Add</a>
                                    <a href="?controller=specialty&action=list" class="btn btn-dark btn-sm ms-2">List</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layout-admin.php') ?>
