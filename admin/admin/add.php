<?php

use Dotenv\Dotenv;

require __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../../models/Admin.php';

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
  $adminFirstname = $_POST['admin-firstname'];
  $adminLastname = $_POST['admin-lastname'];
  $adminEmail = $_POST['admin-email'];
  $adminPassword = $_POST['admin-password'];
  $hashOptions = ['cost' => 11];
  $adminPasswordHash = password_hash($adminPassword, PASSWORD_BCRYPT, $hashOptions);
  
  try {
    // Admin add request
    $sql = 'INSERT INTO Admin (
      admin_firstname,
      admin_lastname,
      admin_email,
      admin_password
    ) VALUES (
      :firstname,
      :lastname,
      :email,
      :passwordHash
    )';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':firstname', $adminFirstname, PDO::PARAM_STR);
    $statement->bindParam(':lastname', $adminLastname, PDO::PARAM_STR);
    $statement->bindParam(':email', $adminEmail, PDO::PARAM_STR);
    $statement->bindParam(':passwordHash', $adminPasswordHash, PDO::PARAM_STR);
    if ($statement->execute()) {
      $message = "Admin added";
      header("Location: list.php");
    } else {
      $error = $statement->errorInfo();
      $logFile = '../../logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to add admin";
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

  <title>KGB : missions | administration | admin</title>
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
          <h2 class="text-uppercase font-monospace">Add admin</h2>
        </div>
        <div>
          <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="link-secondary" href="../../admin.php">Home</a></li>
              <li class="breadcrumb-item"><a class="link-secondary" href="./list.php">Admin list</a></li>
              <li class="breadcrumb-item active text-light" aria-current="page">Add</li>
            </ol>
          </nav>
        </div>
        <!-- ADMIN INTERFACE -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
          <div class="row mt-2 pb-2 mb-4 overflow-x-scroll">
            <form action="" method="post">
              <?php if (isset($message)) : ?>
                <div class="alert <?= $message == 'Admin added' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
                <?php if ($message == 'Admin added') : ?>
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
                <label for="admin-firstname" class="form-label">Firstname :</label>
                <input type="text" class="form-control" id="admin-firstname" name="admin-firstname" value="" maxlength="30" aria-describedby="firstname-help">
                <div id="firstname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="admin-lastname" class="form-label">Lastname :</label>
                <input type="text" class="form-control" id="admin-lastname" name="admin-lastname" value="" maxlength="30" aria-describedby="lastname-help">
                <div id="lastname-help" class="form-text text-light">30 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="admin-email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="admin-email" name="admin-email" value="" maxlength="254" aria-describedby="email-help" required>
                <div id="email-help" class="form-text text-light">Required. 254 characters max.</div>
              </div>
              <div class="mb-3">
                <label for="admin-password" class="form-label">Password :</label>
                <input type="password" class="form-control" id="admin-password" name="admin-password" value="" aria-describedby="password-help" required>
                <div id="password-help" class="form-text text-light">Required</div>
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
