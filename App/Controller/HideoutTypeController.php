<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\HideoutTypeRepository;

class HideoutTypeController
{
    public function listHideoutType(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $hideoutTypeRepository = new hideoutTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $hideoutTypePerPage = 10;
        $pagination = $hideoutTypeRepository->getPaginationForHideoutTypes($hideoutTypePerPage, $search);
        $hideoutTypes = $hideoutTypeRepository->getHideoutTypesWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/hideout-type/list.php');
    }

    public function addHideoutType(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $hideoutTypeRepository = new hideoutTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['hideout-type-name'])) {
                $name = htmlspecialchars($_POST['hideout-type-name']);

                $success = $hideoutTypeRepository->insertHideoutType($name);
                if ($success) {
                    header('Location: ?controller=hideout-type&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=hideout-type&action=list&message=addFail');
                }
            } else {
                throw new Exception("No hideout type name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/hideout-type/add.php');
    }

    public function removeHideoutType(string $SessionUuid): void
    {
        $hideoutTypeRepository = new hideoutTypeRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $id = htmlspecialchars($_POST['delete']);

                $success = $hideoutTypeRepository->deleteHideoutType($id);
                if (!$success) {
                    throw new Exception("Unable to delete hideout type");
                }
            } else {
                throw new Exception("No hideout type id send");
            }
        }
    }

    public function editHideoutType(string $SessionUuid, int $hideoutTypeId): void
    {
        $adminRepository = new AdminRepository();
        $hideoutTypeRepository = new HideoutTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $hideoutType = $hideoutTypeRepository->getHideoutType($hideoutTypeId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['hideout-type-id']) && !empty($_POST['hideout-type-name'])) {
                $id = htmlspecialchars($_POST['hideout-type-id']);
                $name = htmlspecialchars($_POST['hideout-type-name']);

                $success = $hideoutTypeRepository->updateHideoutType($id, $name);
                if ($success) {
                    header('Location: ?controller=hideout-type&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=hideout-type&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No hideout type id and/or name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/hideout-type/edit.php');
    }
}
