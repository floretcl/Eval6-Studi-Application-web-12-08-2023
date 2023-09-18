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

try {
  // Admins request
  $sql = 'SELECT 
    Admin.admin_uuid AS uuid,
    Admin.admin_firstname AS firstName,
    Admin.admin_lastname AS lastName,
    Admin.admin_email AS email,
    Admin.admin_password AS passwordHash,
    Admin.admin_creation_date AS creationDate
    FROM Admin
    ORDER BY admin_creation_date';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($admin = $statement->fetchObject('Admin')) {
      $admins[] = $admin;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the admin list";
}

try {
  // Missions request
  $sql = 'SELECT 
    Mission.mission_uuid AS uuid,
    Mission.mission_code_name AS codeName,
    Mission.mission_title AS title,
    Mission.mission_description AS description,
    Mission.mission_country AS country,
    Mission_type.type_name AS type,
    Mission.mission_specialty AS specialty,
    Mission_status.status_name AS status,
    Mission.start_date AS startDate,
    Mission.end_date AS endDate
    FROM ((Mission
    INNER JOIN Mission_status ON Mission.mission_status = Mission_status.status_id)
    INNER JOIN Mission_type ON Mission.mission_type = Mission_type.type_id)
    ORDER BY mission_status';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($mission = $statement->fetchObject('Mission')) {
      $missions[] = $mission;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the mission list";
}

try {
  // Mission types request
  $sql = 'SELECT 
    Mission_type.type_id AS id,
    Mission_type.type_name AS name
    FROM Mission_type
    ORDER BY type_id';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($missionType = $statement->fetchObject('MissionType')) {
      $missionTypes[] = $missionType;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the mission type list";
}

try {
  // Mission types request
  $sql = 'SELECT 
    Mission_status.status_id AS id,
    Mission_status.status_name AS name
    FROM Mission_status
    ORDER BY status_id';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($status = $statement->fetchObject('MissionStatus')) {
      $missionStatus[] = $status;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the mission status list";
}

try {
  // Mission types request
  $sql = 'SELECT 
    Hideout.hideout_uuid AS uuid,
    Hideout.hideout_code_name AS codeName,
    Hideout.hideout_adress AS adress,
    Hideout.hideout_country AS country,
    Hideout_type.hideout_type_name AS hideoutType
    FROM (Hideout
    INNER JOIN Hideout_type ON Hideout.hideout_type = Hideout_type.hideout_type_id)
    ORDER BY hideout_code_name';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($hideout = $statement->fetchObject('Hideout')) {
      $hideouts[] = $hideout;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the hideout list";
}

try {
  // Mission types request
  $sql = 'SELECT 
    Hideout_type.hideout_type_id AS id,
    Hideout_type.hideout_type_name AS name
    FROM Hideout_type
    ORDER BY hideout_type_id';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($hideoutType = $statement->fetchObject('HideoutType')) {
      $hideoutTypes[] = $hideoutType;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the hideout type list";
}

try {
  // Mission types request
  $sql = 'SELECT 
    Specialty.specialty_name AS name
    FROM Specialty
    ORDER BY specialty_name';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($specialty = $statement->fetchObject('Specialty')) {
      $specialties[] = $specialty;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the specialty list";
}

try {
  // Missions request
  $sql = 'SELECT 
    Agent.agent_uuid AS uuid,
    Agent.agent_code AS code,
    Agent.agent_firstname AS firstName,
    Agent.agent_lastname AS lastName,
    Agent.agent_birthday AS birthday,
    Agent.agent_nationality AS nationality,
    Agent.agent_mission_uuid AS missionUUID
    FROM (Agent
    INNER JOIN Mission ON Mission.mission_uuid = Agent.agent_mission_uuid)
    ORDER BY agent_code';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($agent = $statement->fetchObject('Agent')) {
      $agents[] = $agent;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the agent list";
}

try {
  // Missions request
  $sql = 'SELECT 
    Contact.contact_uuid AS uuid,
    Contact.contact_code_name AS codeName,
    Contact.contact_firstname AS firstName,
    Contact.contact_lastname AS lastName,
    Contact.contact_birthday AS birthday,
    Contact.contact_nationality AS nationality
    FROM Contact
    ORDER BY contact_code_name';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($contact = $statement->fetchObject('Contact')) {
      $contacts[] = $contact;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the contact list";
}

try {
  // Missions request
  $sql = 'SELECT 
    Target.target_uuid AS uuid,
    Target.target_code_name AS codeName,
    Target.target_firstname AS firstName,
    Target.target_lastname AS lastName,
    Target.target_birthday AS birthday,
    Target.target_nationality AS nationality
    FROM Target
    ORDER BY target_code_name';
  $statement = $pdo->prepare($sql);
  if ($statement->execute()) {
    while ($target = $statement->fetchObject('Target')) {
      $targets[] = $target;
    }
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display the target list";
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
              <button class="nav-link link-light" id="admins-admin-tab" data-bs-toggle="pill" data-bs-target="#admins-tab-pane" type="button" role="tab" aria-controls="admins-tab-pane" aria-selected="false">Admins</button>
              <button class="nav-link link-light" id="missions-admin-tab" data-bs-toggle="pill" data-bs-target="#missions-tab-pane" type="button" role="tab" aria-controls="missions-tab-pane" aria-selected="false">Missions</button>          
              <button class="nav-link link-light" id="mission-types-admin-tab" data-bs-toggle="pill" data-bs-target="#mission-types-tab-pane" type="button" role="tab" aria-controls="mission-types-tab-pane" aria-selected="false">Mission types</button>
              <button class="nav-link link-light" id="mission-status-admin-tab" data-bs-toggle="pill" data-bs-target="#mission-status-tab-pane" type="button" role="tab" aria-controls="mission-status-tab-pane" aria-selected="false">Mission status</button>
              <button class="nav-link link-light" id="hideouts-admin-tab" data-bs-toggle="pill" data-bs-target="#hideouts-tab-pane" type="button" role="tab" aria-controls="hideouts-tab-pane" aria-selected="false">Hideouts</button>
              <button class="nav-link link-light" id="hideout-types-admin-tab" data-bs-toggle="pill" data-bs-target="#hideout-types-tab-pane" type="button" role="tab" aria-controls="hideout-type-tab-pane" aria-selected="false">Hideout types</button>
              <button class="nav-link link-light" id="specialties-admin-tab" data-bs-toggle="pill" data-bs-target="#specialties-tab-pane" type="button" role="tab" aria-controls="specialties-tab-pane" aria-selected="false">Specialties</button>
              <button class="nav-link link-light" id="agents-admin-tab" data-bs-toggle="pill" data-bs-target="#agents-tab-pane" type="button" role="tab" aria-controls="agents-tab-pane" aria-selected="false">Agents</button>
              <button class="nav-link link-light" id="contacts-admin-tab" data-bs-toggle="pill" data-bs-target="#contacts-tab-pane" type="button" role="tab" aria-controls="contacts-tab-pane" aria-selected="false">Contacts</button>
              <button class="nav-link link-light" id="targets-admin-tab" data-bs-toggle="pill" data-bs-target="#targets-tab-pane" type="button" role="tab" aria-controls="" aria-selected="false">Targets</button>
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
              <div class="tab-pane fade" id="admins-tab-pane" role="tabpanel" aria-labelledby="admins-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">UUID</th>
                        <th class="text-uppercase">Firstname</th>
                        <th class="text-uppercase">Lastname</th>
                        <th class="text-uppercase">Email</th>
                        <th class="text-uppercase">Creation date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($admins as $admin): ?>
                      <tr id="<?= $admin->getUUID() ?>" class="pointer-table-row admin-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $admin->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $admin->getFirstName() . '</td>';
                        echo '<td class="font-monospace">' . $admin->getLastName() . '</td>';
                        echo '<td class="font-monospace">' . $admin->getEmail() . '</td>';
                        echo '<td class="font-monospace">' . $admin->getCreationDate() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="missions-tab-pane" role="tabpanel" aria-labelledby="missions-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">UUID</th>
                        <th class="text-uppercase">Code name</th>
                        <th class="text-uppercase">Title</th>
                        <th class="text-uppercase">Description</th>
                        <th class="text-uppercase">Country</th>
                        <th class="text-uppercase">Type</th>
                        <th class="text-uppercase">Specialty</th>
                        <th class="text-uppercase">Status</th>
                        <th class="text-uppercase">Start date</th>
                        <th class="text-uppercase">End date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($missions as $mission): ?>
                      <tr id="<?= $mission->getUUID() ?>" class="pointer-table-row mission-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $mission->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getCodeName() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getTitle() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getDescriptionShort() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getCountry() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getType() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getSpecialty() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getStatus() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getStartDate() . '</td>';
                        echo '<td class="font-monospace">' . $mission->getEndDate() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="mission-types-tab-pane" role="tabpanel" aria-labelledby="mission-types-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">Id</th>
                        <th class="text-uppercase">Type name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($missionTypes as $missionType): ?>
                      <tr id="<?= $missionType->getId() ?>" class="pointer-table-row mission-type-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $missionType->getId() . '</td>';
                        echo '<td class="font-monospace">' . $missionType->getName() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="mission-status-tab-pane" role="tabpanel" aria-labelledby="mission-status-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">Id</th>
                        <th class="text-uppercase">Status name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($missionStatus as $status): ?>
                      <tr id="<?= $status->getId() ?>" class="pointer-table-row mission-status-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $status->getId() . '</td>';
                        echo '<td class="font-monospace">' . $status->getName() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="hideouts-tab-pane" role="tabpanel" aria-labelledby="hideouts-admin-tab" tabindex="0">
              <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">uuid</th>
                        <th class="text-uppercase">code name</th>
                        <th class="text-uppercase">address</th>
                        <th class="text-uppercase">country</th>
                        <th class="text-uppercase">type</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($hideouts as $hideout): ?>
                      <tr id="<?= $hideout->getUUID() ?>" class="pointer-table-row hideout-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $hideout->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $hideout->getCodeName() . '</td>';
                        echo '<td class="font-monospace">' . $hideout->getAdress() . '</td>';
                        echo '<td class="font-monospace">' . $hideout->getCountry() . '</td>';
                        echo '<td class="font-monospace">' . $hideout->getType() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="hideout-types-tab-pane" role="tabpanel" aria-labelledby="hideout-types-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">Id</th>
                        <th class="text-uppercase">Type name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($hideoutTypes as $hideoutType): ?>
                      <tr id="<?= $hideoutType->getId() ?>" class="pointer-table-row hideout-type-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $hideoutType->getId() . '</td>';
                        echo '<td class="font-monospace">' . $hideoutType->getName() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="specialties-tab-pane" role="tabpanel" aria-labelledby="specialties-admin-tab" tabindex="0">
              <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($specialties as $specialty): ?>
                      <tr id="<?= $specialty->getName() ?>" class="pointer-table-row specialty-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $specialty->getName() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="agents-tab-pane" role="tabpanel" aria-labelledby="agents-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">UUID</th>
                        <th class="text-uppercase">Code</th>
                        <th class="text-uppercase">Firstname</th>
                        <th class="text-uppercase">Lastname</th>
                        <th class="text-uppercase">Birthday</th>
                        <th class="text-uppercase">Age</th>
                        <th class="text-uppercase">Nationality</th>
                        <th class="text-uppercase">Mission uuid</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($agents as $agent): ?>
                      <tr id="<?= $agent->getUUID() ?>" class="pointer-table-row agent-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $agent->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getCode() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getFirstName() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getLastName() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getBirthday() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getAge() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getNationality() . '</td>';
                        echo '<td class="font-monospace">' . $agent->getMissionUUID() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="contacts-tab-pane" role="tabpanel" aria-labelledby="contacts-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">UUID</th>
                        <th class="text-uppercase">Code Name</th>
                        <th class="text-uppercase">Firstname</th>
                        <th class="text-uppercase">Lastname</th>
                        <th class="text-uppercase">Birthday</th>
                        <th class="text-uppercase">Age</th>
                        <th class="text-uppercase">Nationality</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($contacts as $contact): ?>
                      <tr id="<?= $contact->getUUID() ?>" class="pointer-table-row contact-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $contact->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getCodeName() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getFirstName() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getLastName() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getBirthday() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getAge() . '</td>';
                        echo '<td class="font-monospace">' . $contact->getNationality() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="targets-tab-pane" role="tabpanel" aria-labelledby="targets-admin-tab" tabindex="0">
                <div class="row mt-2 mb-3">
                  <table class="table table-dark table-striped table-hover">
                    <thead>
                      <tr>
                        <th class="text-uppercase">UUID</th>
                        <th class="text-uppercase">Code Name</th>
                        <th class="text-uppercase">Firstname</th>
                        <th class="text-uppercase">Lastname</th>
                        <th class="text-uppercase">Birthday</th>
                        <th class="text-uppercase">Age</th>
                        <th class="text-uppercase">Nationality</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($targets as $target): ?>
                      <tr id="<?= $target->getUUID() ?>" class="pointer-table-row target-table-row">
                        <?php
                        echo '<td class="font-monospace">' . $target->getUUID() . '</td>';
                        echo '<td class="font-monospace">' . $target->getCodeName() . '</td>';
                        echo '<td class="font-monospace">' . $target->getFirstName() . '</td>';
                        echo '<td class="font-monospace">' . $target->getLastName() . '</td>';
                        echo '<td class="font-monospace">' . $target->getBirthday() . '</td>';
                        echo '<td class="font-monospace">' . $target->getAge() . '</td>';
                        echo '<td class="font-monospace">' . $target->getNationality() . '</td>';
                        ?>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
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
  <script src="./assets/js/admin.js"></script>
</body>

</html>
