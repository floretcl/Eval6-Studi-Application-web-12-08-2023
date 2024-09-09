<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Repository\HideoutRepository;
use App\Repository\HideoutTypeRepository;
use App\Repository\MissionRepository;
use App\Repository\MissionStatusRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\TargetRepository;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\SpecialtyRepository;

class AdministrationController
{
    public function admin(string $SessionUuid): void
    {
        $adminRepository = new AdminRepository();
        $missionRepository = new MissionRepository();
        $hideoutRepository = new HideoutRepository();
        $agentRepository = new AgentRepository();
        $contactRepository = new ContactRepository();
        $targetRepository = new TargetRepository();
        $missionTypeRepository = new MissionTypeRepository();
        $missionStatusRepository = new MissionStatusRepository();
        $hideoutTypeRepository = new hideoutTypeRepository();
        $specialtyRepository = new SpecialtyRepository();

        $currentAdmin = $adminRepository->getAdmin($SessionUuid);
        $nbAdmins = $adminRepository->getNbAdmins();
        $nbMissions = $missionRepository->getNbMissions();
        $nbHideouts = $hideoutRepository->getNbHideouts();
        $nbAgents = $agentRepository->getNbAgents();
        $nbContacts = $contactRepository->getNbContacts();
        $nbTargets = $targetRepository->getNbTargets();
        $nbMissionTypes = $missionTypeRepository->getNbMissionTypes();
        $nbMissionStatus = $missionStatusRepository->getNbMissionStatus();
        $nbHideoutTypes = $hideoutTypeRepository->getNbHideoutTypes();
        $nbSpecialties = $specialtyRepository->getNbSpecialties();

        require(__DIR__ . '/../../templates/admin/admin.php');
    }
}
