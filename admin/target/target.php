<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Target.php';
require_once __DIR__ . '../../../models/Mission.php';

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

$targetMissions = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetUUID = $_POST['target-uuid'];
    $targetCodeName = $_POST['target-code-name'];
    $targetFirstname = $_POST['target-firstname'] ?? "";
    $targetLastname = $_POST['target-lastname'] ?? "";
    $targetBirthday = $_POST['target-birthday'];
    $targetNationality = $_POST['target-nationality'];
    $targetMissions = $_POST['target-missions'] ?? [];

    try {
        // Mission_Target delete request
        $sql = 'DELETE FROM Mission_Target
                WHERE target_uuid = :uuid';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':uuid', $targetUUID, PDO::PARAM_STR);
        if ($statement->execute()) {
            $message = "Target missions deleted";
        } else {
            $error = $statement->errorInfo();
            $logFile = '../../logs/errors.log';
            error_log('Error : ' . $error);
        }

        if (isset($targetMissions)) {
            // Target mission insert request
            $sql = 'INSERT INTO Mission_Target (
                target_uuid,
                mission_uuid
            ) VALUES (
                :target_uuid,
                :mission_uuid
            )';
            $statement = $pdo->prepare($sql);
            foreach ($targetMissions as $mission) {
                if (!empty($mission) || $mission != '') {
                    $statement->bindParam(':target_uuid', $targetUUID, PDO::PARAM_STR);
                    $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                    if ($statement->execute()) {
                        $message = "Target Missions updated";
                    } else {
                        $error = $statement->errorInfo();
                        $logFile = '../../logs/errors.log';
                        error_log('Error : ' . $error);
                    }
                }
            }
        }

        // Target update request
        $sql = 'UPDATE Target
            SET 
            Target.target_code_name = :Codename,
            Target.target_firstname = :firstname,
            Target.target_lastname = :lastname,
            Target.target_birthday = :birthday,
            Target.target_nationality = :nationality
            WHERE target_uuid = :uuid';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':uuid', $targetUUID, PDO::PARAM_STR);
        $statement->bindParam(':Codename', $targetCodeName, PDO::PARAM_STR);
        $statement->bindParam(':firstname', $targetFirstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $targetLastname, PDO::PARAM_STR);
        $statement->bindParam(':birthday', $targetBirthday, PDO::PARAM_STR);
        $statement->bindParam(':nationality', $targetNationality, PDO::PARAM_STR);
        if ($statement->execute()) {
            $message = "Target updated";
        } else {
            $error = $statement->errorInfo();
            $logFile = '../../logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        $message = "Error: unable to update target";
    }
}

try {
    // Target request
    $sql = 'SELECT 
        Target.target_uuid AS uuid,
        Target.target_code_name AS codeName,
        Target.target_firstname AS firstName,
        Target.target_lastname AS lastName,
        Target.target_birthday AS birthday,
        Target.target_nationality AS nationality
        FROM Target
        WHERE Target.target_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
    if ($statement->execute()) {
        $target = $statement->fetchObject('Target');
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display target details";
}

try {
    // Target missions request
    $sql = 'SELECT
        Mission_Target.mission_uuid AS missionUuid
        FROM (Mission_Target
        INNER JOIN Target ON Mission_Target.target_uuid = Target.target_uuid)
        WHERE Mission_Target.target_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
    if ($statement->execute()) {
        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $targetMissions[] = $result['missionUuid'];
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display target missions list";
}

try {
    // Missions request
    $sql = 'SELECT 
        Mission.mission_uuid AS uuid,
        Mission.mission_code_name AS codeName,
        Mission.mission_title AS title,
        Mission.mission_description AS description,
        Mission.mission_country AS country,
        Mission_type.mission_type_name AS type,
        Specialty.specialty_name AS specialty,
        Mission_status.mission_status_name AS status,
        Mission.mission_start_date AS startDate,
        Mission.mission_end_date AS endDate
        FROM (((Mission
        INNER JOIN Mission_type ON Mission.mission_type = Mission_type.mission_type_id)
        INNER JOIN Specialty ON Mission.mission_specialty = Specialty.specialty_id)
        INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($mission = $statement->fetchObject('Mission')) {
            $missions[] = $mission;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display the mission list";
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

    <title>KGB : missions | administration | target</title>
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
                <h2 class="text-uppercase font-monospace">Edit target</h2>
            </div>
            <div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
                        <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Target list</a></li>
                        <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <!-- ADMIN INTERFACE -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
                <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
                    <form action="" method="post">
                        <?php if (isset($message)) : ?>
                            <div class="alert <?= $message == 'Target updated' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center"
                                 role="alert">
                                <?php if ($message == 'Target updated') : ?>
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
                            <label for="target-uuid" class="form-label">UUID :</label>
                            <input type="text" class="form-control" id="target-uuid" name="target-uuid"
                                   value="<?= $target->getUUID() ?>" maxlength="36" aria-describedby="target-uuid-help"
                                   readonly required>
                            <div id="target-uuid-help" class="form-text text-light">Read only.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-code-name" class="form-label">Codename :</label>
                            <input type="text" class="form-control" id="target-code-name" name="target-code-name"
                                   value="<?= $target->getCodeName() ?>" maxlength="30" aria-describedby="code-name-help"
                                   required>
                            <div id="code-name-help" class="form-text text-light">Required. 30 characters max.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-firstname" class="form-label">Firstname :</label>
                            <input type="text" class="form-control" id="target-firstname" name="target-firstname"
                                   value="<?= $target->getFirstName() ?>" maxlength="30"
                                   aria-describedby="firstname-help">
                            <div id="firstname-help" class="form-text text-light">30 characters max.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-lastname" class="form-label">Lastname :</label>
                            <input type="text" class="form-control" id="target-lastname" name="target-lastname"
                                   value="<?= $target->getLastName() ?>" maxlength="30"
                                   aria-describedby="lastname-help">
                            <div id="lastname-help" class="form-text text-light">30 characters max.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-birthday" class="form-label">Birthday :</label>
                            <input type="date" class="form-control" id="target-birthday" name="target-birthday"
                                   value="<?= $target->getBirthday() ?>" aria-describedby="birthday-help" required>
                            <div id="birthday-help" class="form-text text-light">Required.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-nationality" class="form-label">Nationality :</label>
                            <input type="text" class="form-control" id="target-nationality" name="target-nationality"
                                   value="<?= $target->getNationality() ?>" maxlength="50"
                                   aria-describedby="nationality-help" required>
                            <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
                        </div>
                        <div class="mb-3">
                            <label for="target-missions" class="form-label">Missions :</label>
                            <select class="form-select" id="target-missions" name="target-missions[]" size="5"
                                    multiple aria-label="target missions" aria-describedby="missions-help">
                                <option value="">None</option>
                                <?php foreach ($missions as $mission) : ?>
                                    <option value="<?= $mission->getUUID() ?>" <?= in_array($mission->getUUID(), $targetMissions, true) ? "selected" : ""; ?>><?= $mission->getCodeName() ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="missions-help" class="form-text text-light">Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple missions.</div>
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
                                <p>Do you really want to delete this target?</p>
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
<script src="../../assets/js/target/target.js"></script>
</body>

</html>
