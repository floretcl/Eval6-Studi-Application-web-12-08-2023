<?php

namespace App\Controller;

use App\Repository\MissionRepository;

class HomeController
{
    public function home(): void
    {
        $missionRepository = new MissionRepository();

        $missionsPerPage = 10;
        $search = htmlspecialchars($_POST['search'] ?? '');

        $pagination = $missionRepository->getPaginationForMissions($missionsPerPage, $search);
        $missions = $missionRepository->getMissionsWithPagination($search, $pagination['start'], $pagination['perPage']);

        require(__DIR__ . '/../../templates/home.php');
    }
}
