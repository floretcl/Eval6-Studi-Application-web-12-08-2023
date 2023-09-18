<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Agent.php';
require_once __DIR__ . '../../../models/Specialty.php';

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
  $agentUuid = $_POST['agent-uuid'];
  $agentCode = $_POST['agent-code'];
  $agentFirstname = $_POST['agent-firstname'];
  $agentLastname = $_POST['agent-lastname'];
  $agentBirthday = $_POST['agent-birthday'];
  $agentNationality = $_POST['agent-nationality'];
  $agentMissionUuid = $_POST['agent-mission-uuid'];
  $agentSpecialties = $_POST['agent-specialties']; 

  try {
    // Agent_Specialty delete request
    $sql = 'DELETE FROM Agent_Specialty
      WHERE agent_uuid = :id';
    $statement =  $pdo->prepare($sql);
    $statement->bindParam(':id', $agentUuid, PDO::PARAM_STR);
    if ($statement->execute()) {
      $message = "Agent specialties deleted";
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
    
    foreach ($agentSpecialties as $specialty) {
      // Agent_Specialty insert request
      $sql = 'INSERT INTO Agent_Specialty (
          agent_uuid,
          agent_specialty
        ) VALUES (
          :agent_uuid,
          :specialty
        )';
      $statement = $pdo->prepare($sql);
      $statement->bindParam(':agent_uuid', $agentUuid, PDO::PARAM_STR);
      $statement->bindParam(':specialty', $specialty, PDO::PARAM_STR);
      if ($statement->execute()) {
        $message = "Agent specialties updated";
      } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
      }
    }
  } catch (PDOException $e) {
    $message = "Error: unable to update agent specialties";
  }
  
  try {
    // Agent update request
    $sql = 'UPDATE Agent
      SET 
      Agent.agent_code = :code,
      Agent.agent_firstname = :firstname,
      Agent.agent_lastname = :lastname,
      Agent.agent_birthday = :birthday,
      Agent.agent_nationality = :nationality,
      Agent.agent_mission_uuid = :missionUuid
      WHERE agent_uuid = :id LIMIT 1';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $agentUuid, PDO::PARAM_STR);
    $statement->bindParam(':code', $agentCode, PDO::PARAM_STR);
    $statement->bindParam(':firstname', $agentFirstname, PDO::PARAM_STR);
    $statement->bindParam(':lastname', $agentLastname, PDO::PARAM_STR);
    $statement->bindParam(':birthday', $agentBirthday, PDO::PARAM_STR);
    $statement->bindParam(':nationality', $agentNationality, PDO::PARAM_STR);
    $statement->bindParam(':missionUuid', $agentMissionUuid, PDO::PARAM_STR);
    if ($statement->execute()) {
      $message = "Agent updated";
      header("Location: list.php");
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to update agent";
  }
}

try {
  // Agent request
  $sql = 'SELECT 
    Agent.agent_uuid AS uuid,
    Agent.agent_code AS code,
    Agent.agent_firstname AS firstName,
    Agent.agent_lastname AS lastName,
    Agent.agent_birthday AS birthday,
    Agent.agent_nationality AS nationality,
    Agent.agent_mission_uuid AS missionUuid,
    Agent_Specialty.agent_specialty AS specialty
    FROM (Agent
    INNER JOIN Agent_Specialty ON Agent_Specialty.agent_uuid = Agent.agent_uuid)
    WHERE Agent.agent_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
  if ($statement->execute()) {
    while($agent = $statement->fetchObject('Agent')) {
      $agents[] = $agent;
      $agentSpecialties[] = $agent->getSpecialty(); 
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = '../../logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  $message = "Error: unable to display agent details";
}

try {
  // Specialties request
  $sql = 'SELECT 
    Specialty.specialty_name AS name
    FROM Specialty';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while($specialty = $statement->fetchObject('Specialty')) {
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

  <title>KGB : missions | administration | agent</title>
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
          <h2 class="text-uppercase font-monospace">Edit agent</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Agent list</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Agent</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
          <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
              <?php if (isset($message)) : ?>
                <div class="alert <?= $message == 'Agent updated' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                <?php if ($message == 'Agent updated') : ?>
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
                <label for="agent-uuid" class="form-label">UUID :</label>
                <input type="text" class="form-control" id="agent-uuid" name="agent-uuid" value="<?= $agents[0]->getUuid() ?>" readonly required>
              </div>
              <div class="mb-3">
                <label for="agent-code" class="form-label">Code :</label>
                <input type="text" class="form-control" id="agent-code" name="agent-code" value="<?= $agents[0]->getCode() ?>" maxlength="6" aria-describedby="code-help" required>
                <div id="code-help" class="form-text text-light">Required. 6 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="agent-firstname" class="form-label">Firstname :</label>
                <input type="text" class="form-control" id="agent-firstname" name="agent-firstname" value="<?= $agents[0]->getFirstName() ?>" maxlength="30" aria-describedby="firstname-help">
                <div id="firstname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="agent-lastname" class="form-label">Lastname :</label>
                <input type="text" class="form-control" id="agent-lastname" name="agent-lastname" value="<?= $agents[0]->getLastName() ?>" maxlength="30" aria-describedby="lastname-help">
                <div id="lastname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="agent-birthday" class="form-label">Birthday :</label>
                <input type="date" class="form-control" id="agent-birthday" name="agent-birthday" value="<?= $agents[0]->getBirthday() ?>" aria-describedby="birthday-help" required>
                <div id="birthday-help" class="form-text text-light">Required.</div>
              </div>
              <div class="mb-3">
                <label for="agent-nationality" class="form-label">Nationality :</label>
                <input type="text" class="form-control" id="agent-nationality" name="agent-nationality" value="<?= $agents[0]->getNationality() ?>" maxlength="50" aria-describedby="nationality-help" required>
                <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="agent-mission-uuid" class="form-label">Mission uuid :</label>
                <input type="text" class="form-control" id="agent-mission-uuid" name="agent-mission-uuid" value="<?= $agents[0]->getMissionUuid() ?>" maxlength="36" aria-describedby="mission-uuid-help">
                <div id="mission-uuid-help" class="form-text text-light">36 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="agent-specialties" class="form-label">Specialties :</label>
                <select class="form-select" id="agent-specialties" name="agent-specialties[]" size="4" multiple aria-label="agent specialties" aria-describedby="specialties-help" required>
                  <?php foreach($specialties as $specialty) : ?>
                    <option value="<?= $specialty->getName() ?>" <?= in_array($specialty->getName(), $agentSpecialties, true) ? "selected" : ""; ?>><?= $specialty->getName() ?></option>
                  <?php endforeach ?>
                </select>
                <div id="specialties-help" class="form-text text-light">Required. At least one.</div>
              </div>
              <div class="row justify-content-center my-4">
                <div class="col-12">
                  <button type="submit" id="save-button" class="btn btn-primary me-2">Save</button>
                  <button type="button" id="delete-button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                </div>
              </div>
            </form>
          </div>
          <div class="modal text-dark" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete this agent?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="delete-confirm-btn">Delete</button>
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
  <script src="../../assets/js/agent/agent.js"></script>
</body>

</html>
