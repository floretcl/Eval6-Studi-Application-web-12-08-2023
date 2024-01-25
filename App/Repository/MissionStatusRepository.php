<?php

namespace App\Repository;

use App\Entity\MissionStatus;
use App\Database\DatabaseConnection;
use PDO;

class MissionStatusRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getMissionsStatusWithPagination(string $search, int $start, int $perPage): array
    {
        // Mission Status request
        $sql = 'SELECT 
        mission_status_id AS id,
        mission_status_name AS name
        FROM Mission_status
        WHERE mission_status_name LIKE :search
        ORDER BY mission_status_id
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $missionsStatus = [];
        if ($statement->execute()) {
            while ($missionStatus = $statement->fetchObject('\App\Entity\MissionStatus')) {
                $missionsStatus[] = $missionStatus;
            }
        }
        return $missionsStatus;
    }

    public function getPaginationForMissionsStatus(int $perPage, string $search): array
    {
        // Nb Mission Status request & pagination
        $sql = 'SELECT COUNT(*) AS nbMissionStatus 
        FROM Mission_status
        WHERE mission_status_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissionStatus = (int)$result['nbMissionStatus'];
            }
            $nbPages = ceil($nbMissionStatus / $perPage);
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

    public function getMissionsStatus(): array
    {
        $sql = 'SELECT 
        mission_status_id AS id,
        mission_status_name AS name
        FROM Mission_status';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $missionStatus = [];
        if ($statement->execute()) {
            while ($status = $statement->fetchObject('\App\Entity\MissionStatus')) {
                $missionStatus[] = $status;
            }
        }
        return $missionStatus;
    }

    public function getMissionStatus(int $id): MissionStatus
    {
        // Mission status request
        $sql = 'SELECT 
        mission_status_id AS id,
        mission_status_name AS name
        FROM Mission_status
        WHERE mission_status_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        $missionStatus = new MissionStatus();
        if ($statement->execute()) {
            $missionStatus = $statement->fetchObject('\App\Entity\MissionStatus');
        }
        return $missionStatus;
    }

    public function insertMissionStatus(string $name): bool
    {
        //  add request
        $sql = 'INSERT INTO Mission_status (
          mission_status_name
        ) VALUES (
          :name
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteMissionStatus(int $id): bool
    {
        // Delete mission status request
        $sql = 'DELETE 
        FROM Mission_status 
        WHERE mission_status_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateMissionStatus(int $id, string $name): bool
    {
        // Mission status update request
        $sql = 'UPDATE Mission_status
        SET 
        mission_status_id = :id,
        mission_status_name = :name
        WHERE mission_status_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbMissionStatus(): int
    {
        // Nb Mission status request
        $sql = 'SELECT COUNT(*) AS nbMissionStatus FROM Mission_status';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbMissionStatus = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissionStatus = (int)$result['nbMissionStatus'];
            }
        }
        return $nbMissionStatus;
    }
}
