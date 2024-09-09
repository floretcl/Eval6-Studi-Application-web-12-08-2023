<?php

namespace App\Controller;

use Exception;
use App\Repository\MissionTypeRepository;
use App\Repository\AdminRepository;
use Random\RandomException;

class MissionTypeController
{
    public function listMissionType(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $missionTypeRepository = new MissionTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $missionTypePerPage = 10;

        $pagination = $missionTypeRepository->getPaginationForMissionTypes($missionTypePerPage, $search);
        $missionTypes = $missionTypeRepository->getMissionTypesWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/mission-type/list.php');
    }

    /**
     * @throws Exception
     */
    public function addMissionType(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionTypeRepository = new MissionTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['mission-type-name'])) {
                    $name = htmlspecialchars($_POST['mission-type-name']);

                    $success = $missionTypeRepository->insertMissionType($name);
                    if ($success) {
                        header('Location: ?controller=mission-type&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=mission-type&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No mission type name send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-type/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeMissionType(string $SessionUuid): void
    {
        $missionTypeRepository = new MissionTypeRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $id = htmlspecialchars($_POST['delete']);

                    $success = $missionTypeRepository->deleteMissionType($id);
                    if (!$success) {
                        throw new Exception("Unable to delete mission type");
                    }
                } else {
                    throw new Exception("No mission type id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editMissionType(string $SessionUuid, int $missionTypeId): void
    {
        $adminRepository = new AdminRepository();
        $missionTypeRepository = new MissionTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $missionType = $missionTypeRepository->getMissionType($missionTypeId);

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['mission-type-id']) && !empty($_POST['mission-type-name'])) {
                    $id = htmlspecialchars($_POST['mission-type-id']);
                    $name = htmlspecialchars($_POST['mission-type-name']);

                    $success = $missionTypeRepository->updateMissionType($id, $name);
                    if ($success) {
                        header('Location: ?controller=mission-type&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=mission-type&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No mission type id and/or name send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-type/edit.php');
    }
}
