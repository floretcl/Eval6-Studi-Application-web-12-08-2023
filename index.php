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

// Requests to mysql database
$pdo = new PDO($dsn, $username, $password);
try {
  // Nb Missions request
  $sql = 'SELECT COUNT(*) AS nbMissions FROM Mission';
  $statement = $pdo->prepare($sql);
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
    $logFile = './logs/errors.log';
    error_log('Error : ' . $error);
  }
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
    ORDER BY Mission.mission_status
    LIMIT :start, :perPage';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':start', $start, PDO::PARAM_INT);
  $statement->bindValue(':perPage', $perPage, PDO::PARAM_INT);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">

  <meta name="description" content="KGB mission management: list | Studi project | Clément FLORET" />

  <!-- BOOTSTRAP CSS, CSS -->
  <link rel="stylesheet" type="text/css" href="./assets/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">

  <title>KGB : mission management</title>
</head>

<body>
  <div class="d-flex flex-column justify-content-between min-vh-100 bg-dark">
    <header>
      <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
          <a class="navbar-brand mb-0 h1 font-monospace" href="index.php">KGB : missions</a>
          <a class="btn btn-sm btn-outline-secondary font-monospace" href="login.php">Login</a>
        </div>
      </nav>
    </header>

    <main>
      <div class="container text-light">
        <div class="row text-center m-5">
          <h1 class="text-uppercase font-monospace">Mission List</h1>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active text-light">Missions</li>
            </ol>
          </nav>
        </div>
        <!-- MISSION LIST TABLE -->
        <div class="row pt-2 pb-4 mt-2 mb-3">
          <table class="table table-dark table-striped table-hover">
            <thead>
              <tr>
                <th>Code name</th>
                <th>Title</th>
                <th>Type</th>
                <th class="d-none d-md-table-cell">Start date</th>
                <th class="d-none d-md-table-cell">End date</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($missions as $mission): ?>
              <tr id="<?= $mission->getUuid() ?>" class="mission-table-row">
                <?php
                echo '<td class="font-monospace">' . $mission->getCodeName() . '</td>';
                echo '<td class="font-monospace">' . $mission->getTitle() . '</td>';
                echo '<td class="font-monospace">' . $mission->getStatus() . '</td>';
                echo '<td class="d-none d-md-table-cell font-monospace">' . $mission->getStartDate() . '</td>';
                echo '<td class="d-none d-md-table-cell font-monospace">' . $mission->getEndDate() . '</td>';
                ?>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mb-5">
          <nav aria-label="Missions page navigation">
            <ul class="pagination">
              <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="./?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for($page = 1; $page <= $nbPages; $page++): ?>
                <li class="page-item <?= $page == $currentPage ? 'active' : '' ?>">
                  <a class="page-link <?= $page == $currentPage ? 'bg-secondary border-secondary' : '' ?> text-dark" href="./?page=<?= $page ?>"><?= $page ?></a>
                </li>
              <?php endfor ?>
              <li class="page-item <?= $currentPage == $nbPages ? 'disabled' : '' ?>">
                <a class="page-link text-dark" href="./?page=<?= $currentPage + 1 ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </main>

    <footer>
      <div class="container bg-dark text-center py-3">
        <span class="text-light fw-medium font-monospace">KGB : mission management - Studi project</span>
      </div>
    </footer>
  </div>
  <!-- BOOTSTRAP JS, JS -->
  <script src="./assets/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <script src="./assets/js/script.js"></script>
</body>

</html>
