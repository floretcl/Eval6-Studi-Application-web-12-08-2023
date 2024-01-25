<?php

namespace App\Controller;

use App\Repository\AdminRepository;

class AuthController
{
    public function login(): void
    {
        $adminRepository = new AdminRepository();

        // Reset session and session cookie
        $_SESSION = [];
        setcookie("PHPSESSID", "", time() - 3600);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['login-form-email'];
            $password = $_POST['login-form-password'];
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
            require(__DIR__ . '/../../templates/login.php');
        }

    }
}
