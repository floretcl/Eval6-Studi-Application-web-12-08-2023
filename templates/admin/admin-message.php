<?php if (isset($_GET['message'])): ?>
    <div class="alert <?= str_contains($_GET['message'], 'Success') ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
        <?php if (str_contains($_GET['message'], 'Success')): ?>
            <img src="../../assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <div>
                <?= $_GET['message'] == 'addSuccess' ? 'Successful addition' : '' ?>
                <?= $_GET['message'] == 'deleteSuccess' ? 'Deletion successful' : '' ?>
                <?= $_GET['message'] == 'updateSuccess' ? 'Update successful' : '' ?>
            </div>
        <?php else: ?>
            <img src="../../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <div>
                <?= $_GET['message'] == 'addFail' ? 'Addition failed' : '' ?>
                <?= $_GET['message'] == 'deleteFail' ? 'Deletion failed' : '' ?>
                <?= $_GET['message'] == 'updateFail' ? 'Update failed' : '' ?>
            </div>
        <?php endif ?>
    </div>
<?php endif ?>
