<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Mission.php';
require_once __DIR__ . '/models/Agent.php';
require_once __DIR__ . '/models/Hideout.php';
require_once __DIR__ . '/models/Contact.php';
require_once __DIR__ . '/models/Target.php';

// Loading dotenv to load .env const
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database variables
$dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
$username = $_ENV['database_user'];
$password = $_ENV['database_password'];

// Requests to mysql database
$pdo = new PDO($dsn, $username, $password);
try {
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
    INNER JOIN Mission_status ON Mission_status.status_id = Mission.mission_status)
    INNER JOIN Mission_type ON Mission_type.type_id = Mission.mission_type)
    WHERE mission_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
  if ($statement->execute()) {
    $mission = $statement->fetchObject('Mission');
  } else {
    $error = $statement->errorInfo();
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  echo "error: unable to display mission details";
}

try {
  $sql = 'SELECT 
    Agent.agent_uuid AS uuid,
    Agent.agent_code AS code,
    Agent.agent_firstname AS firstName,
    Agent.agent_lastname AS lastName,
    Agent.agent_birthday AS birthday,
    Agent.agent_nationality AS nationality,
    Agent.agent_mission_uuid AS missionUUID
    FROM Agent
    WHERE agent_mission_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
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
  echo "error: unable to display agents details";
}

try {
  $sql = 'SELECT 
    Hideout.hideout_uuid AS uuid,
    Hideout.hideout_code_name AS codeName,
    Hideout.hideout_adress AS adress,
    Hideout.hideout_country AS country,
    Hideout_type.hideout_type_name AS hideoutType
    FROM ((Mission_Hideout
    INNER JOIN Hideout ON Hideout.hideout_uuid = Mission_Hideout.hideout_uuid)
    INNER JOIN Hideout_type ON Hideout_type.hideout_type_id = Hideout.hideout_type)
    WHERE mission_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
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
  echo "error: unable to display hideouts details";
}

try {
  $sql = 'SELECT
    Contact.contact_uuid AS uuid,
    Contact.contact_code_name AS codeName,
    Contact.contact_firstname AS firstName,
    Contact.contact_lastname AS lastName,
    Contact.contact_birthday AS birthday,
    Contact.contact_nationality AS nationality
    FROM Mission_Contact
    INNER JOIN Contact ON Contact.contact_uuid = Mission_Contact.contact_uuid
    WHERE mission_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
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
  echo "error: unable to display contacts details";
}

try {
  $sql = 'SELECT 
    Target.target_uuid AS uuid,
    Target.target_code_name AS codeName,
    Target.target_firstname AS firstName,
    Target.target_lastname AS lastName,
    Target.target_birthday AS birthday,
    Target.target_nationality AS nationality
    FROM Mission_Target
    INNER JOIN Target ON Target.target_uuid = Mission_Target.target_uuid
    WHERE mission_uuid = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
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
  echo "error: unable to display targets details";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">

  <meta name="description" content="KGB missions : mission detail, Studi project, Clément FLORET" />

  <!-- BOOTSTRAP CSS, CSS -->
  <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">

  <title>KGB : missions | mission details</title>
</head>

<body>
  <div class="d-flex flex-column min-vh-100 justify-content-between bg-dark">
    <header>
      <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
          <a class="navbar-brand mb-0 h1 font-monospace" href="./index.php">KGB : missions</a>
          <a class="btn btn-sm btn-outline-secondary font-monospace" href="./login.php">Login</a>
        </div>
      </nav>
    </header>

    <main>
      <div class="container text-light">
        <div class="row text-center my-5">
          <h1 class="text-uppercase font-monospace"><?= $mission->getCodeName(); ?></h1>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="./index.php">Missions</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Details</li>
            </ol>
          </nav>
        </div>
        <!-- MISSION CARD -->
        <div class="card pt-2 pb-4 mt-2 mb-5">
          <h2 class="card-header text-center mb-2">Mission</h2>
          <div class="card-body">
            <h3 class="text-center text-uppercase font-monospace mt-2 mb-3"><?= $mission->getTitle(); ?></h3>
            <p class="card-text text-center font-monospace mb-5"><?= $mission->getDescription(); ?></p>
            <div class="row">
              <div class="col-12 col-lg-6 mt-4">
                <!-- MISSION DETAILS -->
                <h4 class="mb-3 text-uppercase font-monospace">Mission information</h4>
                <div class="card-text mb-3">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">Type :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getType(); ?></span>
                    </li>
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">Required specialty :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getSpecialty(); ?></span>
                    </li>
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">Country :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getCountry(); ?></span>
                    </li>
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">Status :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getStatus(); ?></span>
                    </li>
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">Start :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getStartDateLong(); ?></span>
                    </li>
                    <li class="list-group-item px-0 px-sm-2 px-md-3">
                      <span class="mb-1">End :</span>
                      <span class="fw-bold font-monospace"><?= $mission->getEndDateLong(); ?></span>
                    </li>
                  </ul>
                </div>
              </div>
              <?php if (isset($agents)) : ?>
                <div class="col-12 col-lg-6 mt-4">
                  <!-- MISSION AGENTS -->
                  <h4 class="mb-3 text-uppercase font-monospace"><?= count($agents) > 1 ? count($agents) . ' Agents' : 'Agent' ?></h4>
                  <div class="row">
                    <?php foreach ($agents as $agent) : ?>
                      <div class="col-12 <?= count($agents) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Code :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getCode(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Firstname :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getFirstName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Lastname :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getLastName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Age :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getAge(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Birthday :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getBirthday(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Nationality :</span>
                            <span class="fw-bold font-monospace"><?= $agent->getNationality(); ?></span>
                          </li>
                        </ul>
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endif ?>
              <?php if (isset($hideouts)) : ?>
                <div class="col-12 col-lg-6 mt-4">
                  <!-- MISSION HIDEOUTS -->
                  <h4 class="mb-3 text-uppercase font-monospace"><?= count($hideouts) > 1 ? count($hideouts) . ' Hideouts' : 'Hideout' ?></h4>
                  <div class="row">
                    <?php foreach ($hideouts as $hideout) : ?>
                      <div class="col-12 <?= count($hideouts) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Code name :</span>
                            <span class="fw-bold font-monospace"><?= $hideout->getCodeName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Adress :</span>
                            <span class="fw-bold font-monospace mb-2">
                              <?php foreach ($hideout->getAdressArray() as $adressLine) : ?>
                                <?= $adressLine ?><br>
                              <?php endforeach ?>
                            </span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Country :</span>
                            <span class="fw-bold font-monospace"><?= $hideout->getCountry(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Type :</span>
                            <span class="fw-bold font-monospace"><?= $hideout->getType(); ?></span>
                          </li>
                        </ul>
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endif ?>
              <?php if (isset($contacts)) : ?>
                <div class="col-12 col-lg-6 mt-4">
                  <!-- MISSION CONTACTS -->
                  <h4 class="mb-3 text-uppercase font-monospace"><?= count($contacts) > 1 ? count($contacts) . ' Contacts' : 'Contact' ?></h4>
                  <div class="row">
                    <?php foreach ($contacts as $contact) : ?>
                      <div class="col-12 <?= count($contacts) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Code name :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getCodeName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Firstname :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getFirstName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Lastname :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getLastName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Age :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getAge(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Birthday :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getBirthday(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Nationality :</span>
                            <span class="fw-bold font-monospace"><?= $contact->getNationality(); ?></span>
                          </li>
                        </ul>
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endif ?>
              <?php if (isset($targets)) : ?>
                <div class="col-12 col-lg-6 mt-4">
                  <!-- MISSION TARGETS -->
                  <h4 class="mb-3 text-uppercase font-monospace"><?= count($targets) > 1 ? count($targets) . ' Targets' : 'Target' ?></h4>
                  <div class="row">
                    <?php foreach ($targets as $target) : ?>
                      <div class="col-12 <?= count($targets) > 1 ? 'col-md-6' : '' ?> card-text mb-3">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Code name :</span>
                            <span class="fw-bold font-monospace"><?= $target->getCodeName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Firstname :</span>
                            <span class="fw-bold font-monospace"><?= $target->getFirstName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Lastname :</span>
                            <span class="fw-bold font-monospace"><?= $target->getLastName(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Age :</span>
                            <span class="fw-bold font-monospace"><?= $target->getAge(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Birthday :</span>
                            <span class="fw-bold font-monospace"><?= $target->getBirthday(); ?></span>
                          </li>
                          <li class="list-group-item px-0 px-sm-2 px-md-">
                            <span class="mb-1">Nationality :</span>
                            <span class="fw-bold font-monospace"><?= $target->getNationality(); ?></span>
                          </li>
                        </ul>
                      </div>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endif ?>
            </div>
          </div>
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