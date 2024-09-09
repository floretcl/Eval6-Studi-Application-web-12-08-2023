<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\TargetRepository;
use Random\RandomException;

class TargetController
{
    public function listTarget(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $targetRepository = new TargetRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $targetPerPage = 10;
        $pagination = $targetRepository->getPaginationForTargets($targetPerPage, $search);
        $targets = $targetRepository->getTargetsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/target/list.php');
    }

    /**
     * @throws Exception
     */
    public function addTarget(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $targetRepository = new TargetRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['target-code-name']) && !empty($_POST['target-birthday']) && !empty($_POST['target-nationality'])) {
                    $codeName = htmlspecialchars($_POST['target-code-name']);
                    $firstname = htmlspecialchars($_POST['target-firstname'] ?? "");;
                    $lastname = htmlspecialchars($_POST['target-lastname'] ?? "");;
                    $birthday = htmlspecialchars($_POST['target-birthday']);
                    $nationality = htmlspecialchars($_POST['target-nationality']);

                    $success = $targetRepository->insertTarget($codeName, $firstname, $lastname, $birthday, $nationality);
                    if ($success) {
                        header('Location: ?controller=target&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=target&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No target codename, birthday, nationality send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/target/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeTarget(string $SessionUuid): void
    {
        $targetRepository = new TargetRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $uuid = htmlspecialchars($_POST['delete']);

                    $success = $targetRepository->deleteTarget($uuid);
                    if (!$success) {
                        throw new Exception("Unable to delete target");
                    }
                } else {
                    throw new Exception("No target id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editTarget(string $SessionUuid, string $targetUuid): void
    {
        $adminRepository = new AdminRepository();
        $targetRepository = new TargetRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $target = $targetRepository->getTarget($targetUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['target-uuid']) && !empty($_POST['target-code-name']) && !empty($_POST['target-birthday']) && !empty($_POST['target-nationality'])) {
                    $uuid = htmlspecialchars($_POST['target-uuid']);
                    $codeName = htmlspecialchars($_POST['target-code-name']);
                    $firstname = htmlspecialchars($_POST['target-firstname'] ?? "");
                    $lastname = htmlspecialchars($_POST['target-lastname'] ?? "");
                    $birthday = htmlspecialchars($_POST['target-birthday']);
                    $nationality = htmlspecialchars($_POST['target-nationality']);

                    $success = $targetRepository->updateTarget($uuid, $codeName, $firstname, $lastname, $birthday, $nationality);
                    if ($success) {
                        header('Location: ?controller=target&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=target&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No target uuid and/or email send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/target/edit.php');
    }
}
