<?php

namespace App\Controller;

use Exception;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\AgentSpecialtyRepository;
use App\Repository\MissionRepository;
use App\Repository\SpecialtyRepository;
use Random\RandomException;

class AgentController
{
    public function listAgent(string $SessionUuid, ?string $search): void
    {
        $adminRepository = new AdminRepository();
        $agentRepository = new AgentRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $agentPerPage = 10;
        $pagination = $agentRepository->getPaginationForAgents($agentPerPage, $search);
        $agents = $agentRepository->getAgentsWithPagination($search, $pagination['start'], $pagination['perPage']);
        require(__DIR__ . '/../../templates/admin/agent/list.php');
    }

    /**
     * @throws Exception
     */
    public function addAgent(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionRepository = new MissionRepository();
        $specialtyRepository = new SpecialtyRepository();
        $agentRepository = new AgentRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $missions = $missionRepository->getMissions();
        $specialties = $specialtyRepository->getSpecialties();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['agent-code']) && !empty($_POST['agent-birthday']) && !empty($_POST['agent-nationality']) && !empty($_POST['agent-specialties'])) {
                    $code = htmlspecialchars($_POST['agent-code']);
                    $firstname = htmlspecialchars($_POST['agent-firstname'] ?? '');
                    $lastname = htmlspecialchars($_POST['agent-lastname'] ?? '');
                    $birthday = htmlspecialchars($_POST['agent-birthday']);
                    $nationality = htmlspecialchars($_POST['agent-nationality']);
                    $specialties = $_POST['agent-specialties'];
                    $mission = htmlspecialchars($_POST['agent-mission'] ?? '');

                    $success = $agentRepository->insertAgent($code, $firstname, $lastname, $birthday, $nationality, $specialties);
                    if ($success) {
                        header('Location: ?controller=agent&action=list&message=addSuccess');
                    } else {
                        header('Location: ?controller=agent&action=list&message=addFail');
                    }
                } else {
                    throw new Exception("No agent code, birthday, nationality, specialties send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/agent/add.php');
    }

    /**
     * @throws Exception
     */
    public function removeAgent(string $SessionUuid): void
    {
        $agentRepository = new AgentRepository();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['delete'])) {
                    $uuid = htmlspecialchars($_POST['delete']);

                    $success = $agentRepository->deleteAgent($uuid);
                    if (!$success) {
                        throw new Exception("Unable to delete agent");
                    }
                } else {
                    throw new Exception("No agent id send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
    }

    /**
     * @throws Exception
     */
    public function editAgent(string $SessionUuid, string $agentUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionRepository = new MissionRepository();
        $specialtyRepository = new SpecialtyRepository();
        $agentRepository = new AgentRepository();
        $agentSpecialtyRepository = new AgentSpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);

        $agent = $agentRepository->getAgent($agentUuid);
        $agentSpecialties = $agentSpecialtyRepository->getAgentSpecialties($agentUuid);
        $missions = $missionRepository->getMissions();
        $specialties = $specialtyRepository->getSpecialties();

        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
        $csrfToken = $_SESSION['csrf-token'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf-token']) && $_POST['csrf-token'] !== $_SESSION['csrf-token']) {
                if (!empty($_POST['agent-uuid']) && !empty($_POST['agent-code']) && !empty($_POST['agent-birthday']) && !empty($_POST['agent-nationality']) && !empty($_POST['agent-specialties'])) {
                    $uuid = htmlspecialchars($_POST['agent-uuid']);
                    $code = htmlspecialchars($_POST['agent-code']);
                    $firstname = htmlspecialchars($_POST['agent-firstname'] ?? '');
                    $lastname = htmlspecialchars($_POST['agent-lastname'] ?? '');
                    $birthday = htmlspecialchars($_POST['agent-birthday']);
                    $nationality = htmlspecialchars($_POST['agent-nationality']);
                    $specialties = $_POST['agent-specialties'];

                    $success = $agentRepository->updateAgent($uuid, $code, $firstname, $lastname, $birthday, $nationality, $specialties);
                    if ($success) {
                        header('Location: ?controller=agent&action=list&message=updateSuccess');
                    } else {
                        header('Location: ?controller=agent&action=list&message=updateFail');
                    }
                } else {
                    throw new Exception("No agent uuid and/or email send");
                }
            } else {
                throw new Exception("405: Method Not Allowed");
            }
        }
        require(__DIR__ . '/../../templates/admin/agent/edit.php');
    }
}
