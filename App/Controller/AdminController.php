<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use Random\RandomException;

class AdminController
{
    public function listAdmin(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $adminsPerPage = 10;
        $pagination = $adminRepository->getPaginationForAdmins($adminsPerPage, $search);
        $admins = $adminRepository->getAdminsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/admin/list.php');
    }

    /**
     * @throws Exception
     */
    public function addAdmin(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['admin-email']) && !empty($_POST['admin-password'])) {
                    $firstname = htmlspecialchars($_POST['admin-firstname'] ?? '');
                    $lastname = htmlspecialchars($_POST['admin-lastname'] ?? '');
                    $email = htmlspecialchars($_POST['admin-email']);
                    $password = htmlspecialchars($_POST['admin-password']);
                    $hashOptions = ['cost' => 11];
                    $passwordHash = password_hash($password, PASSWORD_BCRYPT, $hashOptions);

                    $success = $adminRepository->insertAdmin($firstname, $lastname, $email, $passwordHash);
                    if ($success) {
                        header('Location: ?controller=admin&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=admin&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No admin email and/or password send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/admin/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeAdmin(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $uuid = htmlspecialchars($_POST['delete']);

                    $currentAdminUuid = $currentAdmin->getUUID();
                    if ($currentAdminUuid !== $uuid) {
                        $success = $adminRepository->deleteAdmin($uuid);
                        if (!$success) {
                            throw new Exception("Unable to delete admin");
                        }
                    } else {
                        throw new Exception("Unable to delete current admin");
                    }
                } else {
                    throw new Exception("No admin id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editAdmin(string $SessionUuid, string $adminUuid): void
    {
        $adminRepository = new AdminRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $admin = $adminRepository->getAdmin($adminUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['admin-uuid']) && !empty($_POST['admin-email'])) {
                    $uuid = htmlspecialchars($_POST['admin-uuid']);
                    $firstname = htmlspecialchars($_POST['admin-firstname'] ?? '');
                    $lastname = htmlspecialchars($_POST['admin-lastname'] ?? '');
                    $email = htmlspecialchars($_POST['admin-email']);

                    $success = $adminRepository->updateAdmin($uuid, $firstname, $lastname, $email);
                    if ($success) {
                        header('Location: ?controller=admin&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=admin&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No admin uuid and/or email send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/admin/edit.php');
    }
}
