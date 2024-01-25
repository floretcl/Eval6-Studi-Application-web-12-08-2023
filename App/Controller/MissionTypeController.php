<?php

namespace App\Controller;

use Exception;
use App\Repository\MissionTypeRepository;
use App\Repository\AdminRepository;

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

    public function addMissionType(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionTypeRepository = new MissionTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['mission-type-name'])) {
                $name = $_POST['mission-type-name'];

                $success = $missionTypeRepository->insertMissionType($name);
                if ($success) {
                    header('Location: ?controller=mission-type&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=mission-type&action=list&message=addFail');
                }
            } else {
                throw new Exception("No mission type name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-type/add.php');
    }

    public function removeMissionType(string $SessionUuid): void
    {
        $missionTypeRepository = new MissionTypeRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $id = $_POST['delete'];

                $success = $missionTypeRepository->deleteMissionType($id);
                if (!$success) {
                    throw new Exception("Unable to delete mission type");
                }
            } else {
                throw new Exception("No mission type id send");
            }
        }
    }

    public function editMissionType(string $SessionUuid, int $missionTypeId): void
    {
        $adminRepository = new AdminRepository();
        $missionTypeRepository = new MissionTypeRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $missionType = $missionTypeRepository->getMissionType($missionTypeId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['mission-type-id']) && !empty($_POST['mission-type-name'])) {
                $id = $_POST['mission-type-id'];
                $name = $_POST['mission-type-name'];

                $success = $missionTypeRepository->updateMissionType($id, $name);
                if ($success) {
                    header('Location: ?controller=mission-type&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=mission-type&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No mission type id and/or name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-type/edit.php');
    }
}
