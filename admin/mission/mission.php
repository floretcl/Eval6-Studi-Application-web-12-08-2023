<?php

    use Dotenv\Dotenv;

    require __DIR__ . '../../../vendor/autoload.php';
    require_once __DIR__ . '../../../models/Mission.php';
    require_once __DIR__ . '../../../models/MissionType.php';
    require_once __DIR__ . '../../../models/Specialty.php';
    require_once __DIR__ . '../../../models/MissionStatus.php';

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
        $missionUUID = $_POST['mission-uuid'];
        $missionCodeName = $_POST['mission-codename'];
        $missionTitle = $_POST['mission-title'];
        $missionDescription = $_POST['mission-description'];
        $missionCountry = $_POST['mission-country'];
        $missionType = $_POST['mission-type'];
        $missionSpecialty = $_POST['mission-specialty'];
        $missionStatus = $_POST['mission-status'];
        $missionStartDate = $_POST['mission-start-date'];
        $missionEndDate = $_POST['mission-end-date'];

        try {

            // Mission update request
            $sql = 'UPDATE Mission
                SET 
                Mission.mission_code_name = :codeName,
                Mission.mission_title = :title,
                Mission.mission_description = :description,
                Mission.mission_country = :country,
                Mission.mission_type = :type,
                Mission.mission_specialty = :specialty,
                Mission.mission_status = :status,
                Mission.mission_start_date = :startDate,
                Mission.mission_end_date = :endDate
                WHERE mission_uuid = :uuid';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':uuid', $missionUUID, PDO::PARAM_STR);
            $statement->bindParam(':codeName', $missionCodeName, PDO::PARAM_STR);
            $statement->bindParam(':title', $missionTitle, PDO::PARAM_STR);
            $statement->bindParam(':description', $missionDescription, PDO::PARAM_STR);
            $statement->bindParam(':country', $missionCountry, PDO::PARAM_STR);
            $statement->bindParam(':type', $missionType, PDO::PARAM_STR);
            $statement->bindParam(':specialty', $missionSpecialty, PDO::PARAM_STR);
            $statement->bindParam(':status', $missionStatus, PDO::PARAM_STR);
            $statement->bindParam(':startDate', $missionStartDate, PDO::PARAM_STR);
            $statement->bindParam(':endDate', $missionEndDate, PDO::PARAM_STR);
            if ($statement->execute()) {
                $message = "Mission updated";
            } else {
                $error = $statement->errorInfo();
                $logFile = '../../logs/errors.log';
                error_log('Error : ' . $error);
            }
        } catch (PDOException $e) {
            $message = "Error: unable to update mission";
        }
    }

    try {
        // Mission request
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
            INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)
            WHERE mission_uuid = :uuid';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
        if ($statement->execute()) {
            $mission = $statement->fetchObject('Mission');
        } else {
            $error = $statement->errorInfo();
            $logFile = '../../logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        $message = "Error: unable to display mission details";
    }

    try {
        // Specialties request
        $sql = 'SELECT 
            Specialty.specialty_id AS id,
            Specialty.specialty_name AS name
            FROM Specialty';
        $statement = $pdo->prepare($sql);
        if ($statement->execute()) {
            while ($specialty = $statement->fetchObject('Specialty')) {
                $specialties[] = $specialty;
            }
        } else {
            $error = $statement->errorInfo();
            $logFile = '../../logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        $message = "Error: unable to display specialties list";
    }

    try {
        $sql = 'SELECT 
            Mission_type.mission_type_id AS id,
            Mission_type.mission_type_name AS name
            FROM Mission_type';
        $statement = $pdo->prepare($sql);
        if ($statement->execute()) {
            while ($type = $statement->fetchObject('MissionType')) {
                $missionsType[] = $type;
            }
        } else {
            $error = $statement->errorInfo();
            $logFile = './logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        echo "error: unable to display mission type";
    }

    try {
        $sql = 'SELECT 
            Mission_status.mission_status_id AS id,
            Mission_status.mission_status_name AS name
            FROM Mission_status';
        $statement = $pdo->prepare($sql);
        if ($statement->execute()) {
            while ($status = $statement->fetchObject('MissionStatus')) {
                $missionsStatus[] = $status;
            }
        } else {
            $error = $statement->errorInfo();
            $logFile = './logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        echo "error: unable to display mission status";
    }

    try {
        $sql = 'SELECT
            Hideout.hideout_code_name AS codeName
            FROM (Mission_Hideout
            INNER JOIN Hideout ON Mission_Hideout.hideout_uuid = Hideout.hideout_uuid)
            WHERE mission_uuid = :uuid';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $hideoutsCodeName[] = $result['codeName'];
            }
        } else {
            $error = $statement->errorInfo();
            $logFile = './logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        echo "error: unable to display mission hideouts";
    }

    try {
        $sql = 'SELECT
            Contact.contact_code_name AS codeName
            FROM (Mission_Contact
            INNER JOIN Contact ON Mission_Contact.contact_uuid = Contact.contact_uuid)
            WHERE mission_uuid = :uuid';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $contactsCodeName[] = $result['codeName'];
            }
        } else {
            $error = $statement->errorInfo();
            $logFile = './logs/errors.log';
            error_log('Error : ' . $error);
        }
    } catch (PDOException $e) {
        echo "error: unable to display mission contacts";
    }

try {
    $sql = 'SELECT
            Target.target_code_name AS codeName
            FROM (Mission_Target
            INNER JOIN Target ON Mission_Target.target_uuid = Target.target_uuid)
            WHERE mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
    if ($statement->execute()) {
        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $targetsCodeName[] = $result['codeName'];
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = './logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    echo "error: unable to display mission targets";
}

try {
    $sql = 'SELECT
        Agent.agent_code AS code
        FROM (Mission_Agent
        INNER JOIN Agent ON Mission_Agent.agent_uuid = Agent.agent_uuid)
        WHERE mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $_GET['id'], PDO::PARAM_STR);
    if ($statement->execute()) {
        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $agentsCode[] = $result['code'];
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = './logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    echo "error: unable to display mission agents";
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

    <title>KGB : missions | administration | mission</title>
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
                <h2 class="text-uppercase font-monospace">Edit mission</h2>
            </div>
            <div>
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
                        <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Mission list</a></li>
                        <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <!-- ADMIN INTERFACE -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
                <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
                    <form action="" method="post">
                        <?php if (isset($message)) : ?>
                            <div class="alert <?= $message == 'Mission updated' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center"
                                 role="alert">
                                <?php if ($message == 'Mission updated') : ?>
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
                                <?php foreach ($missionsType as $type) : ?>
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
                        <?php if (isset($hideoutsCodeName)) : ?>
                            <div class="mb-3">
                                <label for="mission-hideouts" class="form-label">Hideout(s) :</label>
                                <select class="form-select" id="mission-hideouts" name="mission-hideouts[]" size="<?= count($hideoutsCodeName) ?>"
                                        multiple aria-label="mission hideouts" aria-describedby="hideouts-help" disabled>
                                    <?php foreach ($hideoutsCodeName as $hideout) : ?>
                                        <option value="<?= $hideout ?>" selected><?= $hideout ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="hideouts-help" class="form-text text-light"></div>
                            </div>
                        <?php endif ?>
                        <?php if (isset($contactsCodeName)) : ?>
                            <div class="mb-3">
                                <label for="mission-contacts" class="form-label">Contact(s) :</label>
                                <select class="form-select" id="mission-contacts" name="mission-contacts[]" size="<?= count($contactsCodeName) ?>"
                                        multiple aria-label="mission contacts" aria-describedby="contacts-help" disabled>
                                    <?php foreach ($contactsCodeName as $contact) : ?>
                                        <option value="<?= $contact ?>" selected><?= $contact ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="contacts-help" class="form-text text-light"></div>
                            </div>
                        <?php endif ?>
                        <?php if (isset($agentsCode)) : ?>
                            <div class="mb-3">
                                <label for="mission-agents" class="form-label">Agent(s) :</label>
                                <select class="form-select" id="mission-agents" name="mission-agents[]" size="<?= count($agentsCode) ?>"
                                        multiple aria-label="mission agents" aria-describedby="agents-help" disabled>
                                    <?php foreach ($agentsCode as $agent) : ?>
                                        <option value="<?= $agent ?>" selected><?= $agent ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="agents-help" class="form-text text-light">Required.</div>
                            </div>
                        <?php endif ?>
                        <?php if (isset($targetsCodeName)) : ?>
                            <div class="mb-3">
                                <label for="mission-targets" class="form-label">Target(s) :</label>
                                <select class="form-select" id="mission-targets" name="mission-targets[]" size="<?= count($targetsCodeName) ?>"
                                        multiple aria-label="mission targets" aria-describedby="targets-help" disabled>
                                    <?php foreach ($targetsCodeName as $target) : ?>
                                        <option value="<?= $target ?>" selected><?= $target ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="targets-help" class="form-text text-light">Required.</div>
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
    </main>

    <footer>
        <div class="container bg-dark text-center py-3">
            <span class="text-light fw-medium font-monospace">KGB : mission management - Studi project</span>
        </div>
    </footer>
</div>
<!-- BOOTSTRAP JS, JS -->
<script src="../../assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../../assets/js/mission/mission.js"></script>
</body>

</html>
