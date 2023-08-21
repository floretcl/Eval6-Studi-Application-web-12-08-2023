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
          <h1>Mission List</h1>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active text-light">Missions</li>
            </ol>
          </nav>
        </div>
        <div class="row pt-2 pb-4 mt-2 mb-5">
          <table class="table table-dark table-striped table-hover">
            <thead>
              <tr>
                <th>Code name</th>
                <th>Title</th>
                <th>Type</th>
                <th>Start date</th>
                <th>End date</th>
              </tr>
            </thead>
            <tbody>
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
                  INNER JOIN Mission_status ON Mission.mission_status = Mission_status.status_id)
                  INNER JOIN Mission_type ON Mission.mission_type = Mission_type.type_id)';
                $statement = $pdo->prepare($sql);
                if ($statement->execute()) {
                  while ($mission = $statement->fetchObject('Mission')) {
              ?>
              <tr id="<?= $mission->getUuid() ?>" class="mission-table-row">
                <?php
                echo '<td>' . $mission->getCodeName() . '</td>';
                echo '<td>' . $mission->getTitle() . '</td>';
                echo '<td>' . $mission->getStatus() . '</td>';
                echo '<td>' . $mission->getStartDate() . '</td>';
                echo '<td>' . $mission->getEndDate() . '</td>';
                ?>
              </tr>
              <?php
                  }
                } else {
                  $error = $statement->errorInfo();
                  $logFile = './logs/errors.log';
                  error_log('Error : ' . $error);
                }
              } catch (PDOException $e) {
                echo "error: unable to display the mission list";
              }
              ?>
            </tbody>
          </table>
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
  <script src="./assets/js/script.js"></script>
</body>

</html>