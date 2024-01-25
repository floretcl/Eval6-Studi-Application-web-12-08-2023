<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\TargetRepository;
use App\Repository\AgentRepository;

class DetailController
{
    public function detail(string $uuid): void
    {
        $missionRepository = new MissionRepository();
        $hideoutRepository = new HideoutRepository();
        $agentRepository = new AgentRepository();
        $contactRepository = new ContactRepository();
        $targetRepository = new TargetRepository();

        $mission = $missionRepository->getMission($uuid);
        $hideouts = $hideoutRepository->getHideoutsFromMission($uuid);
        $agents = $agentRepository->getAgentsFromMission($uuid);
        $contacts = $contactRepository->getContactsFromMission($uuid);
        $targets = $targetRepository->getTargetsFromMission($uuid);

        require(__DIR__ . '/../../templates/detail.php');
    }
}
