<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/MissionType.php';

// Loading dotenv to load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '../../../');
$dotenv->load();

// Database variables
$dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
$username = $_ENV['database_user'];
$password = $_ENV['database_password'];

// Requests to mysql database
$pdo = new PDO($dsn, $username, $password);


session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true && isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
} else {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $missionTypeId = $_POST['mission-type-id'];
    $missionTypeName = $_POST['mission-type-name'];

    try {
        // Mission type update request
        $sql = 'UPDATE Mission_type
            SET 
            Mission_type.mission_type_id = :id,
            Mission_type.mission_type_name = :name
            WHERE mission_type_id = :id';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $missionTypeId, PDO::PARAM_STR);
        $statement->bindParam(':name', $missionTypeName, PDO::PARAM_STR);
        if ($statement->execute()) {
            $message = "Mission type updated";
        } else {
            $error = $statement->errorInfo();
            $logFile = '../../logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        $message = "Error: unable to update mission type";
    }
}

try {
    // Mission type request
    $sql = 'SELECT 
        Mission_type.mission_type_id AS id,
        Mission_type.mission_type_name AS name
        FROM Mission_type
        WHERE mission_type_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    if ($statement->execute()) {
        $missionType = $statement->fetchObject('MissionType');
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display mission type details";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">

    <meta name="description" content="KGB missions : administration, Studi project, Clément FLORET"/>

    <!-- BOOTSTRAP CSS, CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <title>KGB : missions | administration | mission type</title>
</head>

<body>
<div class="d-flex flex-column min-vh-100 justify-content-between bg-dark">
    <header>
        <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand mb-0 h1 font-monospace" href="../../admin.php">KGB : missions</a>
                <div class="d-flex flex-row flex-wrap align-items-center">
            <span class="navbar-text me-2">
              Hello, <?= $firstName . ' ' . $lastName ?> |
            </span>
                    <a class="nav-link link-light me-3" href="../../index.php" target="_blank">Go on website</a>
                    <a class="btn btn-sm btn-outline-secondary font-monospace" href="../../login.php">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container-fluid container-sm text-light">
            <div class="text-center my-5">
                <h1 class="text-uppercase font-monospace">Administration</h1>
                <h2 class="text-uppercase font-monospace">Edit mission type</h2>
            </div>
            <div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
                        <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Mission type list</a></li>
                        <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <!-- ADMIN INTERFACE -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
                <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
                    <form action="" method="post">
                        <?php if (isset($message)) : ?>
                            <div class="alert <?= $message == 'Mission type updated' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center"
                                 role="alert">
                                <?php if ($message == 'Mission type updated') : ?>
                                    <img src="../../assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32"
                                         height="32" class="me-2">
                                <?php else : ?>
                                    <img src="../../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap"
                                         width="32" height="32" class="me-2">
                                <?php endif ?>
                                <div>
                                    <?= $message ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="mb-3">
                            <label for="mission-type-id" class="form-label">Id :</label>
                            <input type="text" class="form-control" id="mission-type-id" name="mission-type-id"
                                   value="<?= $missionType->getId() ?>" aria-describedby="mission-type-id-help"
                                   readonly required>
                            <div id="mission-type-id-help" class="form-text text-light">Read only.</div>
                        </div>
                        <div class="mb-3">
                            <label for="mission-type-name" class="form-label">Name :</label>
                            <input type="text" class="form-control" id="mission-type-name" name="mission-type-name"
                                   value="<?= $missionType->getName() ?>" maxlength="50" aria-describedby="mission-type-name-help"
                                   required>
                            <div id="mission-type-name-help" class="form-text text-light">Required. 50 characters max.</div>
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
                                <p>Do you really want to delete this mission type?</p>
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
    </main>

    <footer>
        <div class="container bg-dark text-center py-3">
            <span class="text-light fw-medium font-monospace">KGB : mission management - Studi project</span>
        </div>
    </footer>
</div>
<!-- BOOTSTRAP JS, JS -->
<script src="../../assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../../assets/js/mission-type/mission-type.js"></script>
</body>

</html>
