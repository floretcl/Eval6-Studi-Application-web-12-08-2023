<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Admin.php';
require_once __DIR__ . '/models/Mission.php';
require_once __DIR__ . '/models/MissionType.php';
require_once __DIR__ . '/models/MissionStatus.php';
require_once __DIR__ . '/models/Hideout.php';
require_once __DIR__ . '/models/HideoutType.php';
require_once __DIR__ . '/models/Specialty.php';
require_once __DIR__ . '/models/Agent.php';
require_once __DIR__ . '/models/Contact.php';
require_once __DIR__ . '/models/Target.php';

// Loading dotenv to load .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true && isset($_SESSION['firstName']) && isset($_SESSION['lastName'])) {
  $firstName = $_SESSION['firstName'];
  $lastName = $_SESSION['lastName'];
} else {
  header("Location: login.php");
  exit;
}

// Database variables
$dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
$username = $_ENV['database_user'];
$password = $_ENV['database_password'];

// Requests to mysql database
$pdo = new PDO($dsn, $username, $password);
try {
  // Nb Admins request
  $sql = 'SELECT COUNT(*) AS nbAdmins FROM Admin';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbAdmins = (int) $result['nbAdmins'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of admins";
}

try {
  // Nb Missions request
  $sql = 'SELECT COUNT(*) AS nbMissions FROM Mission';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbMissions = (int) $result['nbMissions'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of missions";
}

try {
  // Nb Hideouts request
  $sql = 'SELECT COUNT(*) AS nbHideouts FROM Hideout';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbHideouts = (int) $result['nbHideouts'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of hideouts";
}

try {
  // Nb Agents request
  $sql = 'SELECT COUNT(*) AS nbAgents FROM Agent';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbAgents = (int) $result['nbAgents'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of agents";
}

try {
  // Nb Contacts request
  $sql = 'SELECT COUNT(*) AS nbContacts FROM Contact';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbContacts = (int) $result['nbContacts'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of contacts";
}

try {
  // Nb Targets request
  $sql = 'SELECT COUNT(*) AS nbTargets FROM Target';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbTargets = (int) $result['nbTargets'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of targets";
}

try {
  // Nb Mission types request
  $sql = 'SELECT COUNT(*) AS nbMissionTypes FROM Mission_type';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbMissionTypes = (int) $result['nbMissionTypes'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of mission types";
}

try {
  // Nb Mission status request
  $sql = 'SELECT COUNT(*) AS nbMissionStatus FROM Mission_status';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbMissionStatus = (int) $result['nbMissionStatus'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of mission status";
}

try {
  // Nb Mission status request
  $sql = 'SELECT COUNT(*) AS nbHideoutTypes FROM Hideout_type';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbHideoutTypes = (int) $result['nbHideoutTypes'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of mission status";
}

try {
  // Nb Specialties request
  $sql = 'SELECT COUNT(*) AS nbSpecialties FROM Specialty';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbSpecialties = (int) $result['nbSpecialties'];
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to get number of specialties";
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
  <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">

  <title>KGB : missions | administration</title>
</head>

<body>
  <div class="d-flex flex-column min-vh-100 justify-content-between bg-dark">
    <header>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
          <a class="navbar-brand mb-0 h1 font-monospace" href="./admin.php">KGB : missions</a>
          <div class="d-flex flex-row flex-wrap align-items-center">
            <span class="navbar-text me-2">
              Hello, <?= $firstName . ' ' . $lastName ?> |
            </span>
            <a class="nav-link link-light me-3" href="./index.php" target="_blank">Go on website</a>
            <a class="btn btn-sm btn-outline-secondary font-monospace" href="./login.php">Logout</a>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="container text-light">
        <div class="row text-center my-5">
          <h1 class="text-uppercase font-monospace">Administration</h1>
        </div>
        <!-- ADMIN INTERFACE -->
        <div class="row justify-content-center mb-3">
          <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
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
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbAdmins ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/admin/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/admin/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                </ul>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Missions
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbMissions ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/mission/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/mission/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Hideouts
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbHideouts ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/hideout/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/hideout/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Agents
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbAgents ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/agent/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/agent/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Contacts
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbContacts ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/contact/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/contact/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Targets
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbTargets ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/target/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/target/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                </ul>
                <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Mission types
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbMissionTypes ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/mission-type/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/mission-type/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                    Mission status
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbMissionStatus ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/mission-status/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/mission-status/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Hideout types
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbHideoutTypes ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/hideout-type/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/hideout-type/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-row justify-content-start align-items-center me-3 me-md-5">
                      Specialties
                      <span class="badge bg-primary rounded-pill ms-1"><?= $nbSpecialties ?></span>
                    </div>
                    <div class="d-flex flex-nowrap">
                      <a href="./admin/specialty/add.php" class="btn btn-dark btn-sm">Add</a>
                      <a href="./admin/specialty/list.php" class="btn btn-dark btn-sm ms-2">Edit</a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <?php endif ?>
        </div>
      </div>
    </main>

    <footer>
      <div class="container bg-dark text-center py-3">
        <span class="text-light fw-medium font-monospace">KGB : mission management - Studi project</span>
      </div>
    </footer>
  </div>
  <!-- BOOTSTRAP JS, JS -->
  <script src="./assets/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>
