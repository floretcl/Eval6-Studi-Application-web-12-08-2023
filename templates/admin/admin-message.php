<?php if (isset($_GET['message'])): ?>
    <div class="alert <?= str_contains($_GET['message'], 'Success') ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
        <?php if (str_contains($_GET['message'], 'Success')): ?>
            <img src="../../assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <div>
                <?= htmlspecialchars($_GET['message']) === 'addSuccess' ? 'Successful addition' : '' ?>
                <?= htmlspecialchars($_GET['message']) === 'deleteSuccess' ? 'Deletion successful' : '' ?>
                <?= htmlspecialchars($_GET['message']) === 'updateSuccess' ? 'Update successful' : '' ?>
            </div>
        <?php else: ?>
            <img src="../../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <div>
                <?= htmlspecialchars($_GET['message']) === 'addFail' ? 'Addition failed' : '' ?>
                <?= htmlspecialchars($_GET['message']) === 'deleteFail' ? 'Deletion failed' : '' ?>
                <?= htmlspecialchars($_GET['message']) === 'updateFail' ? 'Update failed' : '' ?>
            </div>
        <?php endif ?>
    </div>
<?php endif ?>
