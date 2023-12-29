<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Mission.php';
require_once __DIR__ . '../../../models/MissionType.php';
require_once __DIR__ . '../../../models/Specialty.php';
require_once __DIR__ . '../../../models/MissionStatus.php';
require_once __DIR__ . '../../../models/Target.php';
require_once __DIR__ . '../../../models/Hideout.php';
require_once __DIR__ . '../../../models/Contact.php';
require_once __DIR__ . '../../../models/Agent.php';

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
    $missionCodeName = $_POST['mission-codename'];
    $missionTitle = $_POST['mission-title'];
    $missionDescription = $_POST['mission-description'];
    $missionCountry = $_POST['mission-country'];
    $missionType = $_POST['mission-type'];
    $missionSpecialty = $_POST['mission-specialty'];
    $missionStatus = $_POST['mission-status'];
    $missionStartDate = $_POST['mission-start-date'];
    $missionEndDate = $_POST['mission-end-date'];
    $missionHideouts = $_POST['mission-hideouts'];
    $missionContacts = $_POST['mission-contacts'];
    $missionAgents = $_POST['mission-agents'];
    $missionTargets = $_POST['mission-targets'];

try {
    // Mission add request
    $sql = 'INSERT INTO Mission (
      mission_code_name,
      mission_title,
      mission_description,
      mission_country,
      mission_type,
      mission_specialty,
      mission_status,
      mission_start_date,
      mission_end_date
    ) VALUES (
      :codename,
      :title,
      :description,
      :country,
      :type,
      :specialty,
      :status,
      :start_date,
      :end_date
    )';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':codename', $missionCodeName, PDO::PARAM_STR);
    $statement->bindParam(':title', $missionTitle, PDO::PARAM_STR);
    $statement->bindParam(':description', $missionDescription, PDO::PARAM_STR);
    $statement->bindParam(':country', $missionCountry, PDO::PARAM_STR);
    $statement->bindParam(':type', $missionType, PDO::PARAM_STR);
    $statement->bindParam(':specialty', $missionSpecialty, PDO::PARAM_STR);
    $statement->bindParam(':status', $missionStatus, PDO::PARAM_STR);
    $statement->bindParam(':start_date', $missionStartDate, PDO::PARAM_STR);
    $statement->bindParam(':end_date', $missionEndDate, PDO::PARAM_STR);
    if ($statement->execute()) {
        if (isset($missionHideouts)) {
            // Mission_Hideout insert request
            $sql = 'INSERT INTO Mission_Hideout (
                mission_uuid,
                hideout_uuid
            ) VALUES (
                (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
                :hideout_uuid
            )';
            $statement = $pdo->prepare($sql);
            foreach ($missionHideouts as $hideoutUUID) {
                $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
                $statement->bindParam(':hideout_uuid', $hideoutUUID, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $message = "Mission hideout updated";
                } else {
                    $error = $statement->errorInfo();
                    $logFile = '../../logs/errors.log';
                    error_log('Error : ' . $error);
                }
            }
        }
        if (isset($missionContacts)) {
            // Mission_Contact insert request
            $sql = 'INSERT INTO Mission_Contact (
                    mission_uuid,
                    contact_uuid
                ) VALUES (
                    (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
                    :contact_uuid
                )';
            $statement = $pdo->prepare($sql);
            foreach ($missionContacts as $contactUUID) {
                $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
                $statement->bindParam(':contact_uuid', $contactUUID, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $message = "Mission contact updated";
                } else {
                    $error = $statement->errorInfo();
                    $logFile = '../../logs/errors.log';
                    error_log('Error : ' . $error);
                }
            }
        }
        if (isset($missionTargets)) {
            // Mission_Target insert request
            $sql = 'INSERT INTO Mission_Target (
                    mission_uuid,
                    target_uuid
                ) VALUES (
                    (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
                    :target_uuid
                )';
            $statement = $pdo->prepare($sql);
            foreach ($missionTargets as $targetUUID) {
                $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
                $statement->bindParam(':target_uuid', $targetUUID, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $message = "Mission target updated";
                } else {
                    $error = $statement->errorInfo();
                    $logFile = '../../logs/errors.log';
                    error_log('Error : ' . $error);
                }
            }
        }

        if (isset($missionAgents)) {
            $sql = 'UPDATE Agent
                    SET agent_mission = (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name)
                    WHERE agent_uuid = :agent_uuid';
            $statement = $pdo->prepare($sql);
            foreach ($missionAgents as $agentUUID) {
                $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
                $statement->bindParam(':agent_uuid', $agentUUID, PDO::PARAM_STR);
                if ($statement->execute()) {
                    $message = "Agent mission updated";
                } else {
                    $error = $statement->errorInfo();
                    $logFile = '../../logs/errors.log';
                    error_log('Error : ' . $error);
                }
            }
        }
      $message = "Mission added";
      header("Location: list.php");
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to add mission " . $e;
  }
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
    // Hideouts request
    $sql = 'SELECT 
        Hideout.hideout_uuid AS uuid,
        Hideout.hideout_code_name AS codeName,
        Hideout.hideout_address AS address,
        Hideout.hideout_country AS country,
        Hideout.hideout_type AS hideoutType
        FROM Hideout';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($hideout = $statement->fetchObject('Hideout')) {
            $hideouts[] = $hideout;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display hideout list";
}

try {
    // Contacts request
    $sql = 'SELECT 
        Contact.contact_uuid AS uuid,
        Contact.contact_code_name AS codeName,
        Contact.contact_firstname AS firstName,
        Contact.contact_lastname AS lastName,
        Contact.contact_birthday AS birthday,
        Contact.contact_nationality AS nationality
        FROM Contact';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($contact = $statement->fetchObject('Contact')) {
            $contacts[] = $contact;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display contact list";
}

try {
    // Targets request
    $sql = 'SELECT 
            Target.target_uuid AS uuid,
            Target.target_code_name AS codeName,
            Target.target_firstname AS firstName,
            Target.target_lastname AS lastName,
            Target.target_birthday AS birthday,
            Target.target_nationality AS nationality
            FROM Target';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($target = $statement->fetchObject('Target')) {
            $targets[] = $target;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display target list";
}

try {
    // Agents request
    $sql = 'SELECT 
        Agent.agent_uuid AS uuid,
        Agent.agent_code AS code,
        Agent.agent_firstname AS firstName,
        Agent.agent_lastname AS lastName,
        Agent.agent_birthday AS birthday,
        Agent.agent_nationality AS nationality
        FROM Agent';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($agent = $statement->fetchObject('Agent')) {
            $agents[] = $agent;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display agent list";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">

  <meta name="description" content="KGB missions : administration, Studi project, Clément FLORET" />

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
          <h2 class="text-uppercase font-monospace">Add mission</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Mission list</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
          <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
              <?php if (isset($message)) : ?>
                <div class="alert <?= $message == 'Mission added' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                <?php if ($message == 'Mission added') : ?>
                  <img src="../../assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
                <?php else : ?>
                  <img src="../../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
                <?php endif ?>
                  <div>
                    <?= $message ?>
                  </div>
                </div>
              <?php endif ?>
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
                        <?php foreach ($missionsType as $type) : ?>
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
                    <input type="datetime-local" class="form-control" id="mission-start-date" name="mission-start-date"
                           value="" aria-describedby="start-date-help" required>
                    <div id="start-date-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="mission-end-date" class="form-label">End date :</label>
                    <input type="datetime-local" class="form-control" id="mission-end-date" name="mission-end-date"
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
                        <div id="hideouts-help" class="form-text text-light">Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple hideouts.</div>
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
                        <div id="contacts-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple contacts.</div>
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
                        <div id="agents-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple agents.</div>
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
                        <div id="targets-help" class="form-text text-light">Required. Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple targets.</div>
                    </div>
                <?php endif ?>
              <div class="row justify-content-center my-4">
                <div class="col-12">
                  <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                  <a href="./list.php" id="cancel-button" class="btn btn-secondary me-2">Cancel</a>
                </div>
              </div>
            </form>
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
</body>

</html>
