<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Hideout.php';
require_once __DIR__ . '../../../models/HideoutType.php';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hideoutCodeName = $_POST['hideout-code-name'];
    $hideoutAddress = $_POST['hideout-address'];
    $hideoutCountry = $_POST['hideout-country'];
    $hideoutType = $_POST['hideout-type'];
    $hideoutMissions = $_POST['hideout-missions'] ?? [];

  try {
    // Hideout add request
    $sql = 'INSERT INTO Hideout (
      hideout_code_name,
      hideout_address,
      hideout_country,
      hideout_type
    ) VALUES (
      :codename,
      :address,
      :country,
      :type
    )';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':codename', $hideoutCodeName, PDO::PARAM_STR);
    $statement->bindParam(':address', $hideoutAddress, PDO::PARAM_STR);
    $statement->bindParam(':country', $hideoutCountry, PDO::PARAM_STR);
    $statement->bindParam(':type', $hideoutType, PDO::PARAM_STR);
    if ($statement->execute()) {
        if (isset($hideoutMissions)) {
            foreach ($hideoutMissions as $mission) {
                if (!empty($mission) || $mission != '') {
                    // Hideout missions insert request
                    $sql = 'INSERT INTO Mission_Hideout (
                        hideout_uuid,
                        mission_uuid
                      ) VALUES (
                        (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = :hideout_codename),
                        :mission_uuid
                      )';
                    $statement = $pdo->prepare($sql);
                    $statement->bindParam(':hideout_codename', $hideoutCodeName, PDO::PARAM_STR);
                    $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                    if ($statement->execute()) {
                        $message = "Hideout missions updated";
                    } else {
                        $error = $statement->errorInfo();
                        $logFile = '../../logs/errors.log';
                        error_log('Error : ' . $error);
                    }
                }
            }
        }
      $message = "Hideout added";
      header("Location: list.php");
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to add hideout";
  }
}

try {
    $sql = 'SELECT 
            Hideout_type.hideout_type_id AS id,
            Hideout_type.hideout_type_name AS name
            FROM Hideout_type';
    $statement = $pdo->prepare($sql);
    if ($statement->execute()) {
        while ($type = $statement->fetchObject('HideoutType')) {
            $hideoutTypes[] = $type;
        }
    } else {
        $error = $statement->errorInfo();
        $logFile = './logs/errors.log';
        error_log('Error : ' . $error);
    }
} catch (PDOException $e) {
    echo "error: unable to display hideout type";
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
        INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)';
    $statement = $pdo->prepare($sql);
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

  <title>KGB : missions | administration | hideout</title>
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
          <h2 class="text-uppercase font-monospace">Add hideout</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Hideout list</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
          <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
              <?php if (isset($message)) : ?>
                <div class="alert <?= $message == 'Hideout added' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                <?php if ($message == 'Hideout added') : ?>
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
                <label for="hideout-code-name" class="form-label">Codename:</label>
                <input type="text" class="form-control" id="hideout-code-name" name="hideout-code-name" value="" maxlength="30" aria-describedby="code-name-help" required>
                <div id="code-name-help" class="form-text text-light">Required. 30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="hideout-address" class="form-label">Address :</label>
                <input type="text" class="form-control" id="hideout-address" name="hideout-address" value="" maxlength="255" aria-describedby="address-help" required>
                <div id="address-help" class="form-text text-light">255 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="hideout-country" class="form-label">Country :</label>
                <input type="text" class="form-control" id="hideout-country" name="hideout-country" value="" maxlength="50" aria-describedby="country-help" required>
                <div id="country-help" class="form-text text-light">50 characters max.</div>
              </div>
                <div class="mb-3">
                    <label for="hideout-type" class="form-label">Type :</label>
                    <select class="form-select" id="hideout-type" name="hideout-type"
                            aria-label="hideout type" aria-describedby="type-help" required>
                        <?php foreach ($hideoutTypes as $type) : ?>
                            <option value="<?= $type->getId() ?>"><?= $type->getName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="type-help" class="form-text text-light">Required.</div>
                </div>
                <div class="mb-3">
                    <label for="hideout-missions" class="form-label">Missions :</label>
                    <select class="form-select" id="hideout-missions" name="hideout-missions[]" size="5"
                            multiple aria-label="hideout missions" aria-describedby="missions-help">
                        <option value="">None</option>
                        <?php foreach ($missions as $mission) : ?>
                            <option value="<?= $mission->getUuid() ?>"><?= $mission->getCodeName() ?></option>
                        <?php endforeach ?>
                    </select>
                    <div id="missions-help" class="form-text text-light">Press <kbd>Ctrl</kbd>,<kbd>Cmd</kbd> or <kbd>Shift</kbd> to select multiple missions.</div>
                </div>
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
