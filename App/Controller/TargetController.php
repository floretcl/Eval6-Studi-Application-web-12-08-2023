<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\TargetRepository;

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

    public function addTarget(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $targetRepository = new TargetRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['target-code-name']) && !empty($_POST['target-birthday']) && !empty($_POST['target-nationality'])) {
                $codeName = $_POST['target-code-name'];
                $firstname = $_POST['target-firstname'] ?? "";;
                $lastname = $_POST['target-lastname'] ?? "";;
                $birthday = $_POST['target-birthday'];
                $nationality = $_POST['target-nationality'];

                $success = $targetRepository->insertTarget($codeName, $firstname, $lastname, $birthday, $nationality);
                if ($success) {
                    header('Location: ?controller=target&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=target&action=list&message=addFail');
                }
            } else {
                throw new Exception("No target codename, birthday, nationality send");
            }
        }
        require(__DIR__ . '/../../templates/admin/target/add.php');
    }

    public function removeTarget(string $SessionUuid): void
    {
        $targetRepository = new TargetRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $uuid = $_POST['delete'];

                $success = $targetRepository->deleteTarget($uuid);
                if (!$success) {
                    throw new Exception("Unable to delete target");
                }
            } else {
                throw new Exception("No target id send");
            }
        }
    }

    public function editTarget(string $SessionUuid, string $targetUuid): void
    {
        $adminRepository = new AdminRepository();
        $targetRepository = new TargetRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $target = $targetRepository->getTarget($targetUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['target-uuid']) && !empty($_POST['target-code-name']) && !empty($_POST['target-birthday']) && !empty($_POST['target-nationality'])) {
                $uuid = $_POST['target-uuid'];
                $codeName = $_POST['target-code-name'];
                $firstname = $_POST['target-firstname'] ?? "";
                $lastname = $_POST['target-lastname'] ?? "";
                $birthday = $_POST['target-birthday'];
                $nationality = $_POST['target-nationality'];

                $success = $targetRepository->updateTarget($uuid, $codeName, $firstname, $lastname, $birthday, $nationality);
                if ($success) {
                    header('Location: ?controller=target&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=target&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No target uuid and/or email send");
            }
        }
        require(__DIR__ . '/../../templates/admin/target/edit.php');
    }
}
