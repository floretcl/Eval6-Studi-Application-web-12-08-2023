<?php $description = "KGB missions : administration, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../../../assets/js/target/list.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | administration | targets"?>

<?php ob_start(); ?>
<div class="container-fluid container-sm text-light">
    <div class="text-center my-5">
        <h1 class="text-uppercase font-monospace">Administration</h1>
        <h2 class="text-uppercase font-monospace">Target list</h2>
    </div>
    <div>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="link-secondary" href="?controller=administration">Home</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Target list</li>
            </ol>
        </nav>
    </div>
    <!-- ADMIN INTERFACE -->
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <div class="row justify-content-center gx-5 gy-3 mb-4">
            <div class="col-10 col-sm-7 col-md-6 col-lg-5">
                <form class="d-flex" action="" method="POST" role="search">
                    <input class="form-control me-2" id="search-input" name="search" type="search"
                           placeholder="<?= $search == '' ? 'Search by code name' : '' ?>"
                           value="<?= $search == '' ? '' : htmlspecialchars($search) ?>" aria-label="Search target by code name">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    <?php if (isset($_POST['search'])) : ?>
                        <button class="btn btn-outline-danger" id="reset-search-btn" type="button">Reset
                        </button>
                    <?php endif ?>
                </form>
            </div>
            <div class="col-10 col-sm-5 col-md-6 col-lg-7">
                <a href="?controller=target&action=add" class="btn btn-secondary me-2">Add</a>
                <button type="button" id="delete-button" class="btn btn-danger me-2 disabled"
                        data-bs-toggle="modal" data-bs-target="#delete-modal">Delete
                </button>
            </div>
        </div>
        <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <?php require(__DIR__ . '/../admin-message.php') ?>
            <table class="table table-dark table-striped table-hover">
                <thead>
                <tr>
                    <th class="text-uppercase"><input class="table-checkbox" type="checkbox"
                                                      id="table-group-checkbox"></th>
                    <th class="text-uppercase">UUID</th>
                    <th class="text-uppercase">Codename</th>
                    <th class="text-uppercase">Firstname</th>
                    <th class="text-uppercase">Lastname</th>
                    <th class="text-uppercase">Birthday</th>
                    <th class="text-uppercase">Nationality</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($targets)): ?>
                    <?php foreach ($targets as $target): ?>
                        <tr>
                            <td class="font-monospace">
                                <input id="table-checkbox-<?= $target->getCodeName(); ?>"
                                       name="table-checkbox-<?= $target->getCodeName(); ?>"
                                       class="table-checkbox" type="checkbox"
                                       value="<?= $target->getUUID(); ?>">
                            </td>
                            <td class="font-monospace">
                                <a href="?controller=target&action=edit&id=<?= $target->getUUID(); ?>">
                                    <?= $target->getUUID(); ?>
                                </a>
                            </td>
                            <?php
                            echo '<td class="font-monospace">' . $target->getCodeName() . '</td>';
                            echo '<td class="font-monospace">' . $target->getFirstName() . '</td>';
                            echo '<td class="font-monospace">' . $target->getLastName() . '</td>';
                            echo '<td class="font-monospace">' . $target->getBirthday() . '</td>';
                            echo '<td class="font-monospace">' . $target->getNationality() . '</td>';
                            ?>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </tbody>
            </table>
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
                        <p>Do you really want to delete those targets?</p>
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
        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mb-5">
            <nav aria-label="Targets page navigation">
                <ul class="pagination">
                    <li class="page-item <?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
                        <a class="page-link text-dark"
                           href="?controller=target&action=list&<?= $search != '' ? 'search=' . htmlspecialchars($search) . '&' : '' ?>page=<?= htmlspecialchars($pagination['currentPage'] - 1) ?>"
                           aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($page = 1; $page <= $pagination['nbPages']; $page++): ?>
                        <li class="page-item <?= $page == $pagination['currentPage'] ? 'active' : '' ?>">
                            <a class="page-link <?= $page == $pagination['currentPage'] ? 'bg-secondary border-secondary' : '' ?> text-dark"
                               href="?controller=target&action=list&<?= $search != '' ? 'search=' . htmlspecialchars($search) . '&' : '' ?>page=<?= htmlspecialchars($page) ?>"><?= htmlspecialchars($page) ?></a>
                        </li>
                    <?php endfor ?>
                    <li class="page-item <?= $pagination['currentPage'] == $pagination['nbPages'] ? 'disabled' : '' ?>">
                        <a class="page-link text-dark"
                           href="?controller=target&action=list&<?= $search != '' ? 'search=' . htmlspecialchars($search) . '&' : '' ?>page=<?= htmlspecialchars($pagination['currentPage'] + 1) ?>"
                           aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif ?>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/../layout-admin.php') ?>
