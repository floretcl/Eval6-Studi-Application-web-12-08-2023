<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Mission.php';

// Loading dotenv to load .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database variables
$dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
$username = $_ENV['database_user'];
$password = $_ENV['database_password'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--
        <meta name="viewport" content="Rules..." />
        <meta name="robots" content="Rules..." />
        <meta name="application-name" content="App name..." />
        <meta name="keywords" content="keyword,keyword,keyword..." />
        -->
  <meta name="description" content="Description..." />
  <!--
        <meta name="author" content="Author..." />
        <meta name="creator" content="Creator..." />
        <meta name="publisher" content="Publisher..." />
        
        <meta name="theme-color" content="color..." />
        <meta name="color-scheme" content="light dark..." />
        -->
  <link rel="stylesheet" type="text/css" href="./assets/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">

  <title>Title of web site page</title>
</head>

<body>
  <div class="bg-dark">
    <header>
      <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
          <span class="navbar-brand mb-0 h1">KGB : mission management</span>
          <button class="btn btn-sm btn-outline-secondary" type="button">Login</button>
        </div>
      </nav>
    </header>

    <main>
      <div class="container text-light">
        <div class="text-center m-5">
          <h1>Mission</h1>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="index.php">Missions</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Details</li>
            </ol>
          </nav>
        </div>
        <?php
        // Connection to mysql database
        $dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
        $username = $_ENV['database_user'];
        $password = $_ENV['database_password'];
        try {
          $pdo = new PDO($dsn, $username, $password);
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
          $statement->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
          if ($statement->execute()) {
            while ($mission = $statement->fetchObject('Mission')) {
        ?>
              <div class="card pt-2 pb-4 mt-2 mb-5">
                <h2 class="card-header text-center mb-2"><?= $mission->getCodeName(); ?></h2>
                <div class="card-body">
                  <h3 class="text-center"><?= $mission->getTitle(); ?></h3>
                  <p class="card-text text-center"><?= $mission->getDescription() ?></p>
                  <div class="row mt-4">
                    <div class="col-12 col-5-sm offset-1">
                      <div class="card-text mb-3">
                        <p class="mb-1">Type</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getType(); ?></span>
                      </div>
                      <div class="card-text mb-3">
                        <p class="mb-1">Required specialty</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getSpecialty(); ?></span>
                      </div>
                      <div class="card-text mb-3">
                        <p class="mb-1">Country</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getCountry(); ?></span>
                      </div>
                      <div class="card-text mb-3">
                        <p class="mb-1">Status</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getStatus(); ?></span>
                      </div>
                      <div class="card-text mb-3">
                        <p class="mb-1">Start</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getStartDateLong(); ?></span>
                      </div>
                      <div class="card-text mb-3">
                        <p class="mb-1">End</p>
                        <span class="badge text-bg-dark fs-6"><?= $mission->getEndDateLong(); ?></span>
                      </div>
                    </div>
              <?php
            }
          } else {
            $error = $statement->errorInfo();
            $logFile = './logs/errors.log';
            error_log('Error : ' . $error);
          }
        } catch (PDOException $e) {
          echo "error: unable to display mission informations";
        }
              ?>
                <div class="col-12 col-5-sm offset-1-sm">
                  <div class="card-text mb-3">
                    <p class="mb-1">Agents</p>
                    <div class="row">
                      <?php
                    try {
                      $sql = 'SELECT 
                        Agent.agent_code AS agentCode,
                        Agent.agent_firstname AS agentFirstName,
                        Agent.agent_lastname AS agentLastName,
                        Agent.agent_birthday AS agentBirthday,
                        Agent.agent_nationality AS agentNationality
                        FROM Agent
                        WHERE agent_mission_uuid = :id';
                      $statement = $pdo->prepare($sql);
                      $statement->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
                      if ($statement->execute()) {
                        while ($agent = $statement->fetch(PDO::FETCH_ASSOC)) {
                          ?>
                        <div class="col">
                          <div class="d-inline-flex flex-column justify-content-around mb-4">
                            <span class="badge text-bg-dark fs-6 mb-2"><?= $agent['agentCode']; ?></span>
                            <span class="badge text-bg-dark fs-6 mb-2"><?= $agent['agentFirstName']; ?></span>
                            <span class="badge text-bg-dark fs-6 mb-2"><?= $agent['agentLastName']; ?></span>
                            <span class="badge text-bg-dark fs-6 mb-2"><?= $agent['agentBirthday']; ?></span>
                            <span class="badge text-bg-dark fs-6 mb-2"><?= $agent['agentNationality']; ?></span>
                          </div>
                        </div>
                      <?php
                        }
                      } else {
                        $error = $statement->errorInfo();
                        $logFile = './logs/errors.log';
                        error_log('Error : ' . $error);
                      }
                    } catch (PDOException $e) {
                      echo "error: unable to display agents informations";
                    }
                    ?>
                    </div>
                  </div>
                  <div class="card-text mb-3">
                    <p class="mb-1">Hideouts</p>
                    <div class="row">
                    <?php
                    try {
                      $sql = 'SELECT 
                        Hideout.hideout_code_name AS hideoutCodeName,
                        Hideout.hideout_adress AS hideoutAdress,
                        Hideout.hideout_country AS hideoutCountry,
                        Hideout_type.hideout_type_name AS hideoutType
                        FROM ((Mission_Hideout
                        INNER JOIN Hideout ON Hideout.hideout_uuid = Mission_Hideout.hideout_uuid)
                        INNER JOIN Hideout_type ON Hideout_type.hideout_type_id = Hideout.hideout_type)
                        WHERE mission_uuid = :id';
                      $statement = $pdo->prepare($sql);
                      $statement->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
                      if ($statement->execute()) {
                        while ($hideout = $statement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      <div class="col">
                        <div class="d-inline-flex flex-column justify-content-around mb-4">
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $hideout['hideoutCodeName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $hideout['hideoutAdress']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $hideout['hideoutCountry']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $hideout['hideoutType']; ?></span>
                        </div>
                      </div>
                    <?php
                        }
                      } else {
                        $error = $statement->errorInfo();
                        $logFile = './logs/errors.log';
                        error_log('Error : ' . $error);
                      }
                    } catch (PDOException $e) {
                      echo "error: unable to display hideout informations";
                    }
                    ?>
                    </div>
                  </div>
                  <div class="card-text mb-3">
                    <p class="mb-1">Contacts</p>
                    <div class="row">
                    <?php
                    try {
                      $sql = 'SELECT 
                        Contact.contact_code_name AS contactCodeName,
                        Contact.contact_firstname AS contactFirstName,
                        Contact.contact_lastname AS contactLastName,
                        Contact.contact_birthday AS contactBirthday,
                        Contact.contact_nationality AS contactNationality
                        FROM Mission_Contact
                        INNER JOIN Contact ON Contact.contact_uuid = Mission_Contact.contact_uuid
                        WHERE mission_uuid = :id';
                      $statement = $pdo->prepare($sql);
                      $statement->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
                      if ($statement->execute()) {
                        while ($contact = $statement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      <div class="col">
                        <div class="d-inline-flex flex-column justify-content-around mb-4">
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $contact['contactCodeName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $contact['contactFirstName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $contact['contactLastName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $contact['contactBirthday']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $contact['contactNationality']; ?></span>
                        </div>
                      </div>
                    <?php
                        }
                      } else {
                        $error = $statement->errorInfo();
                        $logFile = './logs/errors.log';
                        error_log('Error : ' . $error);
                      }
                    } catch (PDOException $e) {
                      echo "error: unable to display contacts informations";
                    }
                    ?>
                    </div>
                  </div>
                  <div class="card-text mb-3">
                    <p class="mb-1">Targets</p>
                    <div class="row">
                    <?php
                    try {
                      $sql = 'SELECT 
                        Target.target_code_name AS targetCodeName,
                        Target.target_firstname AS targetFirstName,
                        Target.target_lastname AS targetLastName,
                        Target.target_birthday AS targetBirthday,
                        Target.target_nationality AS targetNationality
                        FROM Mission_Target
                        INNER JOIN Target ON Target.target_uuid = Mission_Target.target_uuid
                        WHERE mission_uuid = :id';
                      $statement = $pdo->prepare($sql);
                      $statement->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
                      if ($statement->execute()) {
                        while ($target = $statement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      <div class="col">
                        <div class="d-inline-flex flex-column justify-content-around mb-4">
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $target['targetCodeName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $target['targetFirstName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $target['targetLastName']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $target['targetBirthday']; ?></span>
                          <span class="badge text-bg-dark fs-6 mb-2"><?= $target['targetNationality']; ?></span>
                        </div>
                      </div>
                    <?php
                        }
                      } else {
                        $error = $statement->errorInfo();
                        $logFile = './logs/errors.log';
                        error_log('Error : ' . $error);
                      }
                    } catch (PDOException $e) {
                      echo "error: unable to display targets informations";
                    }
                    ?>
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div>
    </main>

    <footer>
      <div class="container bg-dark text-center py-3">
        <span class="text-light fw-medium ">KGB : mission management - Studi project</span>
      </div>
    </footer>
  </div>
  <script src="./assets/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>

</html>
