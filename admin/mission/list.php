<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
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

if (isset($_GET['search'])) {
  $search = $_GET['search'];
} else {
  $search = '';
}

if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
  $uuid = $_POST['delete'];

    // Mission_Hideout delete request
    $sql = 'DELETE FROM Mission_Hideout
                WHERE mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
    if ($statement->execute()) {
        $message = "Mission hideouts deleted";
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }

    // Mission_Contact delete request
    $sql = 'DELETE FROM Mission_Contact
                WHERE mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
    if ($statement->execute()) {
        $message = "Mission contacts deleted";
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }

    // Mission_Target delete request
    $sql = 'DELETE FROM Mission_Target
                WHERE mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
    if ($statement->execute()) {
        $message = "Mission targets deleted";
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }

    // Agent mission update request
    $sql = 'UPDATE Agent
                SET agent_mission = NULL
                WHERE agent_mission = :mission_uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':mission_uuid', $uuid, PDO::PARAM_STR);
    if ($statement->execute()) {
        $message = "Agent mission deleted";
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }

  try {
    // Delete mission request
    $sql = 'DELETE 
      FROM Mission 
      WHERE Mission.mission_uuid = :uuid';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
    if ($statement->execute()) {
      $reload = true;
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to delete mission";
  }
}

try {
  // Nb Missions request & pagination
  $sql = 'SELECT COUNT(*) AS nbMissions 
    FROM Mission
    WHERE mission_code_name LIKE :search';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbMissions = (int) $result['nbMissions'];
    }
    $perPage = 10;
    $nbPages = ceil($nbMissions / $perPage);
    if(isset($_GET['page']) && !empty($_GET['page'])){
      $currentPage = (int) strip_tags($_GET['page']);
    } else {
      $currentPage = 1;
    }
    $start = ($currentPage * $perPage) - $perPage;
  } else {
    $error = $statement->errorInfo();
    $logFile = '../../logs/errors.log';
    error_log('Error : ' . $error);
  }
} catch (PDOException $e) {
  $message = "Error: unable to get number of missions";
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
    INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)
    WHERE mission_code_name LIKE :search
    ORDER BY mission_code_name
    LIMIT :start, :perPage';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
  $statement->bindParam(':start', $start, PDO::PARAM_INT);
  $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);
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

if (isset($reload)) {
  if ($reload) {
    header("Refresh:0");
  }
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

  <title>KGB : missions | administration | missions</title>
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
          <h2 class="text-uppercase font-monospace">Mission list</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Mission list</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <div class="row justify-content-center gx-5 gy-3 mb-4">
          <div class="col-10 col-sm-7 col-md-6 col-lg-5">
            <form class="d-flex" action="" method="GET" role="search">
              <input class="form-control me-2" id="search-input" name="search" type="search" placeholder="<?= $search == '' ? 'Search by code name' : '' ?>" value="<?= $search == '' ? '' : $search ?>" aria-label="Search mission by code name">
              <button class="btn btn-outline-success me-2" type="submit">Search</button>
              <?php if (isset($_GET['search'])) : ?>
                <button class="btn btn-outline-danger" id="reset-search-btn" type="button">Reset</button>
              <?php endif ?>
            </form>
          </div>
          <div class="col-10 col-sm-5 col-md-6 col-lg-7">
            <a href="./add.php" class="btn btn-secondary me-2">Add</a>
            <button type="button" id="delete-button" class="btn btn-danger me-2 disabled" data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
          </div>
        </div>
        <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
          <?php if (isset($message)) : ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <img src="../../assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
              <div>
                <?= $message ?>
              </div>
            </div>
          <?php endif ?>
          <table class="table table-dark table-striped table-hover">
            <thead>
              <tr>
                <th class="text-uppercase"><input class="table-checkbox" type="checkbox" id="table-group-checkbox"></th>
                <th class="text-uppercase">UUID</th>
                <th class="text-uppercase">Codename</th>
                <th class="text-uppercase">Title</th>
                <th class="text-uppercase">Description</th>
                <th class="text-uppercase">Country</th>
                <th class="text-uppercase">Type</th>
                <th class="text-uppercase">Specialty</th>
                <th class="text-uppercase">Status</th>
                <th class="text-uppercase">Start_Date</th>
                <th class="text-uppercase">End_Date</th>
              </tr>
            </thead>
            <tbody>
            <?php if (isset($missions)): ?>
              <?php foreach($missions as $mission): ?>
              <tr>
              <td class="font-monospace"><input id="table-checkbox-<?= $mission->getCodeName(); ?>" name="table-checkbox-<?= $mission->getCodeName(); ?>" class="table-checkbox" type="checkbox" value="<?= $mission->getUUID(); ?>"></td>
              <td class="font-monospace">
                <a href="./mission.php?id=<?= $mission->getUUID(); ?>">
                  <?= $mission->getUUID(); ?>
                </a>
              </td>
              <?php
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
            <?php endif ?>
            </tbody>
          </table>
        </div>
        <div class="modal text-dark" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Do you really want to delete those missions?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="delete-confirm-btn">Delete</button>
              </div>
            </div>
          </div>
        </div>
        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mb-5">
          <nav aria-label="Missions page navigation">
            <ul class="pagination">
              <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="?<?= $search != '' ? 'search=' . $search . '&' : '' ?>page=<?= $currentPage - 1 ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for($page = 1; $page <= $nbPages; $page++): ?>
                <li class="page-item <?= $page == $currentPage ? 'active' : '' ?>">
                  <a class="page-link <?= $page == $currentPage ? 'bg-secondary border-secondary' : '' ?> text-dark" href="?<?= $search != '' ? 'search=' . $search . '&' : '' ?>page=<?= $page ?>"><?= $page ?></a>
                </li>
              <?php endfor ?>
              <li class="page-item <?= $currentPage == $nbPages ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="?<?= $search != '' ? 'search=' . $search . '&' : '' ?>page=<?= $currentPage + 1 ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
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
  <script src="../../assets/js/mission/list.js"></script>
</body>

</html>
