<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Admin.php';

// Loading dotenv to load .env const
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Reset session and session cookie
$_SESSION = [];
setcookie("PHPSESSID", "", time() - 3600);

// Database variables
$dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
$username = $_ENV['database_user'];
$password = $_ENV['database_password'];

// Requests to mysql database
$pdo = new PDO($dsn, $username, $password);

if (isset($_POST['login-form-email']) && isset($_POST['login-form-password'])) {
  $email = $_POST['login-form-email'];
  $password = $_POST['login-form-password'];

  try {
    $sql = 'SELECT 
    Admin.admin_uuid AS uuid,
    Admin.admin_firstname AS firstName,
    Admin.admin_lastname AS lastName,
    Admin.admin_email AS email,
    Admin.admin_password AS password,
    Admin.admin_creation_date AS creationDate
    FROM Admin WHERE admin_email = :email';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    if ($statement->execute()) {
      $message = "Error: invalid identifiers";
      while ($admin = $statement->fetchObject('Admin')) {
        if (isset($admin)) {
          $hash = $admin->getPassword();
          $options = array('cost' => 12);
          if (password_verify($password, $hash)) {
            $message = "Valid identifiers";

            session_start();
            $_SESSION['admin'] = true;
            $_SESSION['firstName'] = $admin->getFirstName();
            $_SESSION['lastName'] = $admin->getLastName();
            
            header("Location: admin.php");
            exit;
          }
        }
      }
    } else {
      $error = $statement->errorInfo();
      $logFile = './logs/errors.log';
      error_log('Error : ' . $error);
    }
  } catch (PDOException $e) {
    $message = "Error: unable to connect to database";
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

  <meta name="description" content="KGB missions : login, Studi project, Clément FLORET" />

  <!-- BOOTSTRAP CSS, CSS -->
  <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">

  <title>KGB : missions | login</title>
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
        <div class="text-center my-5">
          <h1 class="text-uppercase font-monospace">Administration</h1>
        </div>
        <!-- LOGIN -->
        <div class="row justify-content-center">
          <div class="col-10 col-sm-9 col-md-7 col-lg-5">
            <form class="form" action="" method="post">
            <?php if (isset($message)) : ?>
              <div class="alert <?= $message == 'Valid identifiers' ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center" role="alert">
            <?php if ($message == 'Valid identifiers') : ?>
              <img src="./assets/bootstrap/icons/check-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <?php else : ?>
              <img src="./assets/bootstrap/icons/exclamation-circle.svg" alt="Bootstrap" width="32" height="32" class="me-2">
            <?php endif ?>
              <div>
                <?= $message ?>
              </div>
            </div>
            <?php endif ?>
              <div class="mb-3">
                <label class="form-label" for="login-form-email">Email</label>
                <input class="form-control" type="email" name="login-form-email" id="login-form-email" required>
              </div>
              <div class="mb-3">
                <label class="form-label" for="login-form-password">Password</label>
                <input class="form-control" type="password" name="login-form-password" id="login-form-password" required>
              </div>
              <div class="text-center">
                <button class="btn btn-light my-4" type="submit" id="login-form-btn">Login</button>
              </div>
            </form>
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