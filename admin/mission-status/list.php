<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
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

if (isset($_GET['search'])) {
  $search = $_GET['search'];
} else {
  $search = '';
}

if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
  $id = $_POST['delete'];
  try {
    // Delete mission status request
    $sql = 'DELETE 
      FROM Mission_status 
      WHERE Mission_status.mission_status_id = :id';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    if ($statement->execute()) {
      $reload = true;
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to delete mission status";
  }
}

try {
  // Nb Missions status request & pagination
  $sql = 'SELECT COUNT(*) AS nbMissionsStatus 
    FROM Mission_status
    WHERE mission_status_name LIKE :search';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
  if ($statement->execute()) {
    while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
      $nbMissionsStatus = (int) $result['nbMissionsStatus'];
    }
    $perPage = 10;
    $nbPages = ceil($nbMissionsStatus / $perPage);
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
  $message = "Error: unable to get number of missions status";
}

try {
    // Missions status request
    $sql = 'SELECT 
        Mission_status.mission_status_id AS id,
        Mission_status.mission_status_name AS name
        FROM Mission_status
        WHERE Mission_status.mission_status_name LIKE :search
        ORDER BY mission_status_id
        LIMIT :start, :perPage';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $statement->bindParam(':start', $start, PDO::PARAM_INT);
    $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    if ($statement->execute()) {
        while ($missionStatus = $statement->fetchObject('MissionStatus')) {
            $missionsStatus[] = $missionStatus;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = '../../logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    $message = "Error: unable to display missions status list";
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

  <title>KGB : missions | administration | missions status</title>
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
          <h2 class="text-uppercase font-monospace">Mission status list</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Mission status list</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
        <div class="row justify-content-center gx-5 gy-3 mb-4">
          <div class="col-10 col-sm-7 col-md-6 col-lg-5">
            <form class="d-flex" action="" method="GET" role="search">
              <input class="form-control me-2" id="search-input" name="search" type="search" placeholder="<?= $search == '' ? 'Search by name' : '' ?>" value="<?= $search == '' ? '' : $search ?>" aria-label="Search mission status by name">
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
                <th class="text-uppercase">Id</th>
                <th class="text-uppercase">Name</th>
              </tr>
            </thead>
            <tbody>
            <?php if (isset($missionsStatus)): ?>
              <?php foreach($missionsStatus as $missionStatus): ?>
              <tr>
              <td class="font-monospace"><input id="table-checkbox-<?= $missionStatus->getName(); ?>" name="table-checkbox-<?= $missionStatus->getName(); ?>" class="table-checkbox" type="checkbox" value="<?= $missionStatus->getId(); ?>"></td>
              <td class="font-monospace">
                  <?= $missionStatus->getId() ?>
              </td>
              <td class="font-monospace">
                  <a href="./mission-status.php?id=<?= $missionStatus->getId(); ?>">
                      <?= $missionStatus->getName(); ?>
                  </a>
              </td>
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
                <p>Do you really want to delete those missions status?</p>
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
          <nav aria-label="Missions status page navigation">
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
  <script src="../../assets/js/mission-status/list.js"></script>
</body>

</html>
