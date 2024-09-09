<?php $description = "KGB missions : mission list, Studi project, Clément FLORET"?>

<?php ob_start(); ?>
<script src="../assets/js/home.js" defer></script>
<?php $js = ob_get_clean(); ?>

<?php $title = "KGB : missions | mission list"?>

<?php ob_start(); ?>
<div class="container text-light">
    <div class="row text-center my-5">
        <h1 class="text-uppercase font-monospace">Mission List</h1>
    </div>
    <!-- MISSION LIST TABLE -->
    <div class="row pt-2 pb-2 mt-2 mb-4">
        <table class="table table-dark table-striped table-hover">
            <thead>
            <tr>
                <th>Code name</th>
                <th>Title</th>
                <th>Type</th>
                <th class="d-none d-md-table-cell">Start date</th>
                <th class="d-none d-md-table-cell">End date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($missions as $mission): ?>
                <tr id="<?= htmlspecialchars($mission->getUUID()) ?>" class="pointer-table-row mission-table-row">
                    <?php
                    echo '<td class="font-monospace">' . htmlspecialchars($mission->getCodeName()) . '</td>';
                    echo '<td class="font-monospace">' . htmlspecialchars($mission->getTitle()) . '</td>';
                    echo '<td class="font-monospace">' . htmlspecialchars($mission->getStatus()) . '</td>';
                    echo '<td class="d-none d-md-table-cell font-monospace">' . $mission->getStartDate() . '</td>';
                    echo '<td class="d-none d-md-table-cell font-monospace">' . $mission->getEndDate() . '</td>';
                    ?>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mb-5">
        <nav aria-label="Missions page navigation">
            <ul class="pagination">
                <li class="page-item <?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
                    <a class="page-link text-dark" href="?page=<?= htmlspecialchars($pagination['currentPage'] - 1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for($page = 1; $page <= $pagination['nbPages']; $page++): ?>
                    <li class="page-item <?= $page == $pagination['currentPage'] ? 'active' : '' ?>">
                        <a class="page-link <?= $page == $pagination['currentPage'] ? 'bg-secondary border-secondary' : '' ?> text-dark" href="?page=<?= htmlspecialchars($page) ?>"><?= htmlspecialchars($page) ?></a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?= $pagination['currentPage'] == $pagination['nbPages'] ? 'disabled' : '' ?>">
                    <a class="page-link text-dark" href="?page=<?= htmlspecialchars($pagination['currentPage'] + 1) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php require(__DIR__ . '/layout.php') ?>
