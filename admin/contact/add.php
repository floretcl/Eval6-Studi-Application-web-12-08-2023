<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Contact.php';
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
  $contactCodeName = $_POST['contact-code-name'];
  $contactFirstname = $_POST['contact-firstname'] ?? "";;
  $contactLastname = $_POST['contact-lastname'] ?? "";;
  $contactBirthday = $_POST['contact-birthday'];
  $contactNationality = $_POST['contact-nationality'];
  $contactMissions = $_POST['contact-missions'] ?? [];

  try {
    // Contact add request
    $sql = 'INSERT INTO Contact (
      contact_code_name,
      contact_firstname,
      contact_lastname,
      contact_birthday,
      contact_nationality
    ) VALUES (
      :codename,
      :firstname,
      :lastname,
      :birthday,
      :nationality
    )';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':codename', $contactCodeName, PDO::PARAM_STR);
    $statement->bindParam(':firstname', $contactFirstname, PDO::PARAM_STR);
    $statement->bindParam(':lastname', $contactLastname, PDO::PARAM_STR);
    $statement->bindParam(':birthday', $contactBirthday, PDO::PARAM_STR);
    $statement->bindParam(':nationality', $contactNationality, PDO::PARAM_STR);
    if ($statement->execute()) {
        if (isset($contactMissions)) {
            foreach ($contactMissions as $mission) {
                if (!empty($mission) || $mission != '') {
                    // Contact missions insert request
                    $sql = 'INSERT INTO Mission_Contact (
                        contact_uuid,
                        mission_uuid
                      ) VALUES (
                        (SELECT contact_uuid FROM Contact WHERE contact_code_name = :contact_codename),
                        :mission_uuid
                      )';
                    $statement = $pdo->prepare($sql);
                    $statement->bindParam(':contact_codename', $contactCodeName, PDO::PARAM_STR);
                    $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                    if ($statement->execute()) {
                        $message = "Contact missions updated";
                    } else {
                        $error = $statement->errorInfo();
                        $logFile = '../../logs/errors.log';
                        error_log('Error : ' . $error);
                    }
                }
            }
        }
      $message = "Contact added";
      header("Location: list.php");
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to add contact";
  }
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

  <title>KGB : missions | administration | contact</title>
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
          <h2 class="text-uppercase font-monospace">Add contact</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Contact list</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
          <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
              <?php if (isset($message)) : ?>
                <div class="alert <?= $message == 'Contact added' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                <?php if ($message == 'Contact added') : ?>
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
                <label for="contact-code-name" class="form-label">Codename:</label>
                <input type="text" class="form-control" id="contact-code-name" name="contact-code-name" value="" maxlength="30" aria-describedby="code-name-help" required>
                <div id="code-name-help" class="form-text text-light">Required. 30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="contact-firstname" class="form-label">Firstname :</label>
                <input type="text" class="form-control" id="contact-firstname" name="contact-firstname" value="" maxlength="30" aria-describedby="firstname-help">
                <div id="firstname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="contact-lastname" class="form-label">Lastname :</label>
                <input type="text" class="form-control" id="contact-lastname" name="contact-lastname" value="" maxlength="30" aria-describedby="lastname-help">
                <div id="lastname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="contact-birthday" class="form-label">Birthday :</label>
                <input type="date" class="form-control" id="contact-birthday" name="contact-birthday" value="" aria-describedby="birthday-help" required>
                <div id="birthday-help" class="form-text text-light">Required.</div>
              </div>
              <div class="mb-3">
                <label for="contact-nationality" class="form-label">Nationality :</label>
                <input type="text" class="form-control" id="contact-nationality" name="contact-nationality" value="" maxlength="50" aria-describedby="nationality-help" required>
                <div id="nationality-help" class="form-text text-light">Required. 50 characters max.</div>
              </div>
                <div class="mb-3">
                    <label for="contact-missions" class="form-label">Missions :</label>
                    <select class="form-select" id="contact-missions" name="contact-missions[]" size="5"
                            multiple aria-label="contact missions" aria-describedby="missions-help">
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
