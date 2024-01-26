<?php

namespace App\Controller;

use Exception;
use Random\RandomException;
use App\Repository\AdminRepository;

class AuthController
{
    /**
     * @throws RandomException
     */
    public function login(): void
    {
        $adminRepository = new AdminRepository();

        // Reset session and session cookie
        $_SESSION = [];
        setcookie("PHPSESSID", "", time() - 3600);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                $email = filter_input(INPUT_POST, 'login-form-email', FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($_POST['login-form-password']);
                $message = $adminRepository->verifyAdmin($email, $password);
                if ($message == 'Valid identifiers') {
                    $uuid = $adminRepository->getAdminUuid($email);

                    session_start();
                    $_SESSION['admin'] = true;
                    $_SESSION['uuid'] = $uuid;
                    header('Location: ?controller=administration');
                } else {
                    require(__DIR__ . '/../../templates/login.php');
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        } else {
            require(__DIR__ . '/../../templates/login.php');
        }
    }
}
