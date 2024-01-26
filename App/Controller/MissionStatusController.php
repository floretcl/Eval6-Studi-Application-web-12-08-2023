<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\MissionStatusRepository;

class MissionStatusController
{
    public function listMissionStatus(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $missionStatusRepository = new MissionStatusRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $missionStatusPerPage = 10;
        $pagination = $missionStatusRepository->getPaginationForMissionsStatus($missionStatusPerPage, $search);
        $missionsStatus = $missionStatusRepository->getMissionsStatusWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/mission-status/list.php');
    }

    public function addMissionStatus(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionStatusRepository = new MissionStatusRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['mission-status-name'])) {
                $name = htmlspecialchars($_POST['mission-status-name']);

                $success =$missionStatusRepository->insertMissionStatus($name);
                if ($success) {
                    header('Location: ?controller=mission-status&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=mission-status&action=list&message=addFail');
                }
            } else {
                throw new Exception("No mission status name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-status/add.php');
    }

    public function removeMissionStatus(string $SessionUuid): void
    {
        $missionStatusRepository = new MissionStatusRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $id = htmlspecialchars($_POST['delete']);

                $success = $missionStatusRepository->deleteMissionStatus($id);
                if (!$success) {
                    throw new Exception("Unable to delete mission status");
                }
            } else {
                throw new Exception("No mission status id send");
            }
        }
    }

    public function editMissionStatus(string $SessionUuid, int $missionStatusId): void
    {
        $adminRepository = new AdminRepository();
        $missionStatusRepository = new MissionStatusRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $missionStatus = $missionStatusRepository->getMissionStatus($missionStatusId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['mission-status-id']) && !empty($_POST['mission-status-name'])) {
                $id = htmlspecialchars($_POST['mission-status-id']);
                $name = htmlspecialchars($_POST['mission-status-name']);

                $success = $missionStatusRepository->updateMissionStatus($id, $name);
                if ($success) {
                    header('Location: ?controller=mission-status&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=mission-status&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No mission status id and/or name send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission-status/edit.php');
    }
}