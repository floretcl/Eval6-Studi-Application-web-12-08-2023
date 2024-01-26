<?php

namespace App\Controller;

use Exception;
use App\Repository\AgentSpecialtyRepository;
use App\Repository\ContactRepository;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\MissionHideoutRepository;
use App\Repository\MissionStatusRepository;
use App\Repository\MissionTargetRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\TargetRepository;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\MissionContactRepository;
use App\Repository\SpecialtyRepository;


class MissionController
{
    public function listMission(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $missionRepository = new MissionRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $missionPerPage = 10;
        $pagination = $missionRepository->getPaginationForMissions($missionPerPage, $search);
        $missions = $missionRepository->getMissionsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/mission/list.php');
    }

    public function addMission(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $agentRepository = new AgentRepository();
        $missionRepository = new MissionRepository();
        $contactRepository = new ContactRepository();
        $hideoutRepository = new HideoutRepository();
        $targetRepository = new TargetRepository();
        $missionTypeRepository = new MissionTypeRepository();
        $missionStatusRepository = new MissionStatusRepository();
        $specialtyRepository = new SpecialtyRepository();
        $agentSpecialtyRepository = new AgentSpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $agents = $agentRepository->getAgents();
        $contacts = $contactRepository->getContacts();
        $hideouts = $hideoutRepository->getHideouts();
        $targets = $targetRepository->getTargets();
        $missionTypes = $missionTypeRepository->getMissionTypes();
        $missionsStatus = $missionStatusRepository->getMissionsStatus();
        $specialties = $specialtyRepository->getSpecialties();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                !empty($_POST['mission-codename']) &&
                !empty($_POST['mission-title']) &&
                !empty($_POST['mission-description']) &&
                !empty($_POST['mission-country']) &&
                !empty($_POST['mission-type']) &&
                !empty($_POST['mission-specialty']) &&
                !empty($_POST['mission-status']) &&
                !empty($_POST['mission-start-date']) &&
                !empty($_POST['mission-contacts']) &&
                !empty($_POST['mission-targets']) &&
                !empty($_POST['mission-agents'])) {
                $codeName = htmlspecialchars($_POST['mission-codename']);
                $title = htmlspecialchars($_POST['mission-title']);
                $description = htmlspecialchars($_POST['mission-description']);
                $country = htmlspecialchars($_POST['mission-country']);
                $type = htmlspecialchars($_POST['mission-type']);
                $specialty = htmlspecialchars($_POST['mission-specialty']);
                $status = htmlspecialchars($_POST['mission-status']);
                $startDate = htmlspecialchars($_POST['mission-start-date']);
                $endDate = htmlspecialchars($_POST['mission-end-date']);
                $hideouts = $_POST['mission-hideouts'] ?? [];
                $contacts = $_POST['mission-contacts'];
                $targets = $_POST['mission-targets'];
                $agents = $_POST['mission-agents'];

                $success = false;
                foreach($agents as $agent) {
                    $agent = htmlspecialchars($agent);
                    $agentSpecialties = $agentSpecialtyRepository->getAgentSpecialties($agent);
                    if ($missionRepository->verifyAgentSpecialties($agentSpecialties, $specialty)) {
                        $success = true;
                    }
                }

                if ($success) {
                    foreach($contacts as $contact) {
                        $contact = htmlspecialchars($contact);
                        $contactCountry = $contactRepository->getContactNationality($contact);
                        if (!$missionRepository->verifyContactCountry($contactCountry, $country)) {
                            $success = false;
                        }
                    }
                }

                if ($success) {
                    if ($hideouts != []) {
                        foreach($hideouts as $hideout) {
                            $hideout = htmlspecialchars($hideout);
                            $hideoutCountry = $hideoutRepository->getHideoutCountry($hideout);
                            if (!$missionRepository->verifyHideoutCountry($hideoutCountry, $country)) {
                                $success = false;
                            }
                        }
                    }
                }

                if ($success) {
                    foreach($agents as $agent) {
                        $agent = htmlspecialchars($agent);
                        $agentCountry = $agentRepository->getAgentNationality($agent);
                        foreach ($targets as $target) {
                            $target = htmlspecialchars($target);
                            $targetCountry = $targetRepository->getTargetNationality($target);
                            if (!$missionRepository->verifyAgentAndTargetCountry($agentCountry, $targetCountry)) {
                                $success = false;
                            }
                        }
                    }
                }

                if ($success) {
                    $success = $missionRepository->insertMission(
                        $codeName,
                        $title,
                        $description,
                        $country,
                        $type,
                        $specialty,
                        $status,
                        $startDate,
                        $endDate,
                        $hideouts,
                        $contacts,
                        $targets,
                        $agents);
                }

                if ($success) {
                    header('Location: ?controller=mission&action=list&message=addSuccess');
                } else {
                    header('Location: ?controller=mission&action=list&message=addFail');
                }
            } else {
                throw new Exception("No correct mission data send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission/add.php');
    }

    public function removeMission(string $SessionUuid): void
    {
        $missionRepository = new MissionRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['delete'])) {
                $uuid = htmlspecialchars($_POST['delete']);

                $success = $missionRepository->deleteMission($uuid);
                if (!$success) {
                    throw new Exception("Unable to delete mission");
                }
            } else {
                throw new Exception("No mission id send");
            }
        }
    }

    public function editMission(string $SessionUuid, string $missionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionRepository = new MissionRepository();
        $agentRepository = new AgentRepository();
        $contactRepository = new ContactRepository();
        $hideoutRepository = new HideoutRepository();
        $targetRepository = new TargetRepository();
        $missionTypeRepository = new MissionTypeRepository();
        $missionStatusRepository = new MissionStatusRepository();
        $specialtyRepository = new SpecialtyRepository();
        $missionHideoutRepository = new MissionHideoutRepository();
        $missionContactRepository = new MissionContactRepository();
        $missionTargetRepository = new MissionTargetRepository();
        $agentSpecialtyRepository = new AgentSpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $mission = $missionRepository->getMission($missionUuid);
        $agents = $agentRepository->getAgents();
        $contacts = $contactRepository->getContacts();
        $hideouts = $hideoutRepository->getHideouts();
        $targets = $targetRepository->getTargets();
        $missionTypes = $missionTypeRepository->getMissionTypes();
        $missionsStatus = $missionStatusRepository->getMissionsStatus();
        $specialties = $specialtyRepository->getSpecialties();
        $missionHideouts = $hideoutRepository->getHideoutsUUIDFromMission($missionUuid);
        $missionContacts = $contactRepository->getContactsUUIDFromMission($missionUuid);
        $missionAgents = $agentRepository->getAgentsUUIDFromMission($missionUuid);
        $missionTargets = $targetRepository->getTargetsUUIDFromMission($missionUuid);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                !empty($_POST['mission-uuid']) &&
                !empty($_POST['mission-codename']) &&
                !empty($_POST['mission-title']) &&
                !empty($_POST['mission-description']) &&
                !empty($_POST['mission-country']) &&
                !empty($_POST['mission-type']) &&
                !empty($_POST['mission-specialty']) &&
                !empty($_POST['mission-status']) &&
                !empty($_POST['mission-start-date']) &&
                !empty($_POST['mission-end-date']) &&
                !empty($_POST['mission-contacts']) &&
                !empty($_POST['mission-targets']) &&
                !empty($_POST['mission-agents'])) {
                $uuid = htmlspecialchars($_POST['mission-uuid']);
                $codename = htmlspecialchars($_POST['mission-codename']);
                $title = htmlspecialchars($_POST['mission-title']);
                $description = htmlspecialchars($_POST['mission-description']);
                $country = htmlspecialchars($_POST['mission-country']);
                $type = htmlspecialchars($_POST['mission-type']);
                $specialty = htmlspecialchars($_POST['mission-specialty']);
                $status = htmlspecialchars($_POST['mission-status']);
                $startDate = htmlspecialchars($_POST['mission-start-date']);
                $endDate = htmlspecialchars($_POST['mission-end-date']);
                $hideouts = $_POST['mission-hideouts'] ?? [];
                $contacts = $_POST['mission-contacts'];
                $targets = $_POST['mission-targets'];
                $agents = $_POST['mission-agents'];

                $success = false;
                foreach($agents as $agent) {
                    $agent = htmlspecialchars($agent);
                    $agentSpecialties = $agentSpecialtyRepository->getAgentSpecialties($agent);
                    if ($missionRepository->verifyAgentSpecialties($agentSpecialties, $specialty)) {
                        $success = true;
                    }
                }

                if ($success) {
                    foreach($contacts as $contact) {
                        $contact = htmlspecialchars($contact);
                        $contactCountry = $contactRepository->getContactNationality($contact);
                        if (!$missionRepository->verifyContactCountry($contactCountry, $country)) {
                            $success = false;
                        }
                    }
                }

                if ($success) {
                    if ($hideouts != []) {
                        foreach($hideouts as $hideout) {
                            $hideout = htmlspecialchars($hideout);
                            $hideoutCountry = $hideoutRepository->getHideoutCountry($hideout);
                            if (!$missionRepository->verifyHideoutCountry($hideoutCountry, $country)) {
                                $success = false;
                            }
                        }
                    }
                }

                if ($success) {
                    foreach($agents as $agent) {
                        $agent = htmlspecialchars($agent);
                        $agentCountry = $agentRepository->getAgentNationality($agent);
                        foreach ($targets as $target) {
                            $target = htmlspecialchars($target);
                            $targetCountry = $targetRepository->getTargetNationality($target);
                            if (!$missionRepository->verifyAgentAndTargetCountry($agentCountry, $targetCountry)) {
                                $success = false;
                            }
                        }
                    }
                }



                if ($success) {
                    $success = $missionRepository->updateMission(
                        $uuid,
                        $codename,
                        $title,
                        $description,
                        $country,
                        $type,
                        $specialty,
                        $status,
                        $startDate,
                        $endDate,
                        $hideouts,
                        $contacts,
                        $targets,
                        $agents);
                }
                if ($success) {
                    header('Location: ?controller=mission&action=list&message=updateSuccess');
                } else {
                    header('Location: ?controller=mission&action=list&message=updateFail');
                }
            } else {
                throw new Exception("No correct mission data send");
            }
        }
        require(__DIR__ . '/../../templates/admin/mission/edit.php');
    }
}
