<?php

namespace App\Repository;

use App\Entity\Mission;
use App\Database\DatabaseConnection;
use PDO;

class MissionRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getMissionsWithPagination(string $search, int $start, int $perPage): array
    {
        // Missions request
        $sql = 'SELECT 
        Mission.mission_uuid AS uuid,
        Mission.mission_code_name AS codeName,
        Mission.mission_title AS title,
        Mission.mission_description AS description,
        Mission.mission_country AS country,
        Mission_type.mission_type_name AS type,
        Specialty.specialty_name AS specialty,
        Mission_status.mission_status_name AS status,
        Mission.mission_start_date AS startDate,
        Mission.mission_end_date AS endDate
        FROM (((Mission
        INNER JOIN Mission_type ON Mission.mission_type = Mission_type.mission_type_id)
        INNER JOIN Specialty ON Mission.mission_specialty = Specialty.specialty_id)
        INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)
        WHERE mission_code_name LIKE :search
        ORDER BY mission_code_name
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $missions = [];
        if ($statement->execute()) {
            while ($mission = $statement->fetchObject('\App\Entity\Mission')) {
                $missions[] = $mission;
            }
        }
        return $missions;
    }

    public function getPaginationForMissions(int $perPage, string $search): array
    {
        // Nb Missions request & pagination
        $sql = 'SELECT COUNT(*) AS nbMissions 
        FROM Mission
        WHERE mission_code_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissions = (int)$result['nbMissions'];
            }
            $nbPages = ceil($nbMissions / $perPage);
            if (!empty($_GET['page'])) {
                $currentPage = (int)strip_tags($_GET['page']);
            } else {
                $currentPage = 1;
            }
            $start = ($currentPage * $perPage) - $perPage;
            $pagination = ['perPage' => $perPage, 'nbPages' => $nbPages, 'currentPage' => $currentPage, 'start' => $start];
        }
        return $pagination;
    }

    public function getMissions(): array
    {
        // Missions request
        $sql = 'SELECT 
        Mission.mission_uuid AS uuid,
        Mission.mission_code_name AS codeName,
        Mission.mission_title AS title,
        Mission.mission_description AS description,
        Mission.mission_country AS country,
        Mission_type.mission_type_name AS type,
        Specialty.specialty_name AS specialty,
        Mission_status.mission_status_name AS status,
        Mission.mission_start_date AS startDate,
        Mission.mission_end_date AS endDate
        FROM (((Mission
        INNER JOIN Mission_type ON Mission.mission_type = Mission_type.mission_type_id)
        INNER JOIN Specialty ON Mission.mission_specialty = Specialty.specialty_id)
        INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $missions = [];
        if ($statement->execute()) {
            while ($mission = $statement->fetchObject('\App\Entity\Mission')) {
                $missions[] = $mission;
            }
        }
        return $missions;
    }

    public function getMission(string $uuid): Mission
    {
        // Mission request
        $sql = 'SELECT 
        Mission.mission_uuid AS uuid,
        Mission.mission_code_name AS codeName,
        Mission.mission_title AS title,
        Mission.mission_description AS description,
        Mission.mission_country AS country,
        Mission_type.mission_type_name AS type,
        Specialty.specialty_name AS specialty,
        Mission_status.mission_status_name AS status,
        Mission.mission_start_date AS startDate,
        Mission.mission_end_date AS endDate
        FROM (((Mission
        INNER JOIN Mission_type ON Mission.mission_type = Mission_type.mission_type_id)
        INNER JOIN Specialty ON Mission.mission_specialty = Specialty.specialty_id)
        INNER JOIN Mission_status ON Mission.mission_status = Mission_status.mission_status_id)
        WHERE mission_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $mission = new Mission();
        if ($statement->execute()) {
            $mission = $statement->fetchObject('\App\Entity\Mission');
        }
        return $mission;
    }

    public function insertMission(
        string $codeName,
        string $title,
        string $description,
        string $country,
        string $type,
        string $specialty,
        string $status,
        string $startDate,
        string $endDate,
        array $hideouts,
        array $contacts,
        array $targets,
        array $agents): bool
    {
        // Mission add request
        $sql = 'INSERT INTO Mission (
          mission_code_name,
          mission_title,
          mission_description,
          mission_country,
          mission_type,
          mission_specialty,
          mission_status,
          mission_start_date,
          mission_end_date
        ) VALUES (
          :codename,
          :title,
          :description,
          :country,
          :type,
          :specialty,
          :status,
          :start_date,
          :end_date
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':codename', $codeName, PDO::PARAM_STR);
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':country', $country, PDO::PARAM_STR);
        $statement->bindParam(':type', $type, PDO::PARAM_STR);
        $statement->bindParam(':specialty', $specialty, PDO::PARAM_STR);
        $statement->bindParam(':status', $status, PDO::PARAM_STR);
        $statement->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $statement->bindParam(':end_date', $endDate, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
            if (!empty($hideouts)) {
                $missionHideoutRepository = new MissionHideoutRepository();
                $success = $missionHideoutRepository->insertMissionHideouts($hideouts, $codeName);
            }
            if ($success && !empty($contacts)) {
                $missionContactRepository = new MissionContactRepository();
                $success = $missionContactRepository->insertMissionContacts($contacts, $codeName);
            }
            if ($success && !empty($targets)) {
                $missionTargetRepository = new MissionTargetRepository();
                $success = $missionTargetRepository->insertMissionTargets($targets, $codeName);
            }
            if ($success && !empty($agents)) {
                $agentRepository = new AgentRepository();
                $success = $agentRepository->updateAgentsMission($agents, $codeName);
            }
        }
        return $success;
    }

    public function deleteMission(string $uuid): bool
    {
        $success = false;

        $missionHideoutRepository = new MissionHideoutRepository();
        if ($missionHideoutRepository->deleteMissionHideouts($uuid)) {
            $missionContactRepository = new MissionContactRepository();
            $success = $missionContactRepository->deleteMissionContacts($uuid);
        }

        if ($success) {
            $missionTargetRepository = new MissionTargetRepository();
            $success = $missionTargetRepository->deleteMissionTargets($uuid);
        }

        if ($success) {
            $agentRepository = new AgentRepository();
            $success = $agentRepository->removeAgentMission($uuid);
        }

        if ($success) {
            // Delete mission request
            $sql = 'DELETE 
            FROM Mission 
            WHERE mission_uuid = :uuid';
            $statement = $this->dbConnection->dbConnect()->prepare($sql);
            $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function updateMission(
        string $uuid,
        string $codeName,
        string $title,
        string $description,
        string $country,
        string $type,
        string $specialty,
        string $status,
        string $startDate,
        string $endDate,
        array $hideouts,
        array $contacts,
        array $targets,
        array $agents): bool
    {
        $missionHideoutRepository = new MissionHideoutRepository();
        $success = $missionHideoutRepository->deleteMissionHideouts($uuid);
        if ($success && !empty($hideouts)) {
            $success = $missionHideoutRepository->insertMissionHideouts($hideouts,$codeName);
        }

        $missionContactRepository = new MissionContactRepository();
        if ($success) {
            $success = $missionContactRepository->deleteMissionContacts($uuid);
        }
        if ($success && !empty($contacts)) {
            $success = $missionContactRepository->insertMissionContacts($contacts,$codeName);
        }

        $missionTargetRepository = new MissionTargetRepository();
        if ($success) {
            $success = $missionTargetRepository->deleteMissionTargets($uuid);
        }
        if ($success && !empty($targets)) {
            $success =$missionTargetRepository->insertMissionTargets($targets,$codeName);
        }

        $agentRepository = new AgentRepository();
        if ($success) {
            $success = $agentRepository->removeAgentMission($uuid);
        }
        if ($success && !empty($agents)) {
            $success = $agentRepository->updateAgentsMission($agents, $codeName);
        }

        if ($success) {
            // Mission update request
            $sql = 'UPDATE Mission
            SET 
            mission_code_name = :codeName,
            mission_title = :title,
            mission_description = :description,
            mission_country = :country,
            mission_type = :type,
            mission_specialty = :specialty,
            mission_status = :status,
            mission_start_date = :startDate,
            mission_end_date = :endDate
            WHERE mission_uuid = :uuid';
            $statement = $this->dbConnection->dbConnect()->prepare($sql);
            $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
            $statement->bindParam(':codeName', $codeName, PDO::PARAM_STR);
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':country', $country, PDO::PARAM_STR);
            $statement->bindParam(':type', $type, PDO::PARAM_STR);
            $statement->bindParam(':specialty', $specialty, PDO::PARAM_STR);
            $statement->bindParam(':status', $status, PDO::PARAM_STR);
            $statement->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $statement->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $success = false;
            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function getNbMissions(): int
    {
        // Nb Missions request
        $sql = 'SELECT COUNT(*) AS nbMissions FROM Mission';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbMissions = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissions = (int)$result['nbMissions'];
            }
        }
        return $nbMissions;
    }

    public function verifyAgentSpecialties(array $agentSpecialties, string $missionSpecialty): bool
    {
        return in_array($missionSpecialty, $agentSpecialties);
    }

    public function verifyHideoutCountry(string $hideoutCountry, string $missionCountry): bool
    {
        return $hideoutCountry == $missionCountry;
    }

    public function verifyContactCountry(string $contactCountry, string $missionCountry): bool
    {
        return $contactCountry == $missionCountry;
    }

    public function verifyAgentAndTargetCountry(string $agentCountry, string $targetCountry): bool
    {
        return $agentCountry != $targetCountry;
    }
}
