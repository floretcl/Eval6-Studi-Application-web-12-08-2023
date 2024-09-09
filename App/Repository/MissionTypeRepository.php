<?php

namespace App\Repository;

use App\Entity\MissionType;
use App\Database\DatabaseConnection;
use PDO;

class MissionTypeRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getMissionTypesWithPagination(string $search, int $start, int $perPage): array
    {
        // Mission Types request
        $sql = 'SELECT 
        mission_type_id AS id,
        mission_type_name AS name
        FROM Mission_type
        WHERE mission_type_name LIKE :search
        ORDER BY mission_type_id
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $missionTypes = [];
        if ($statement->execute()) {
            while ($missionType = $statement->fetchObject('\App\Entity\MissionType')) {
                $missionTypes[] = $missionType;
            }
        }
        return $missionTypes;
    }

    public function getPaginationForMissionTypes(int $perPage, string $search): array
    {
        // Nb Mission Types request & pagination
        $sql = 'SELECT COUNT(*) AS nbMissionTypes 
        FROM Mission_type
        WHERE mission_type_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissionTypes = (int)$result['nbMissionTypes'];
            }
            $nbPages = ceil($nbMissionTypes / $perPage);
            if (!empty($_GET['page'])) {
                $currentPage = (int)htmlspecialchars($_GET['page']);
            } else {
                $currentPage = 1;
            }
            $start = ($currentPage * $perPage) - $perPage;
            $pagination = ['perPage' => $perPage, 'nbPages' => $nbPages, 'currentPage' => $currentPage, 'start' => $start];
        }
        return $pagination;
    }

    public function getMissionTypes(): array
    {
        $sql = 'SELECT 
        mission_type_id AS id,
        mission_type_name AS name
        FROM Mission_type';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $missionTypes = [];
        if ($statement->execute()) {
            while ($type = $statement->fetchObject('\App\Entity\MissionType')) {
                $missionTypes[] = $type;
            }
        }
        return $missionTypes;
    }

    public function getMissionType(int $id): MissionType
    {
        // Mission type request
        $sql = 'SELECT 
        mission_type_id AS id,
        mission_type_name AS name
        FROM Mission_type
        WHERE mission_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        $missionType = new MissionType();
        if ($statement->execute()) {
            $missionType = $statement->fetchObject('\App\Entity\MissionType');
        }
        return $missionType;
    }

    public function insertMissionType(string $name): bool
    {
        //  add request
        $sql = 'INSERT INTO Mission_type (
          mission_type_name
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

    public function deleteMissionType(int $id): bool
    {
        // Delete mission type request
        $sql = 'DELETE 
        FROM Mission_type 
        WHERE mission_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateMissionType(int $id, string $name): bool
    {
        // Mission type update request
        $sql = 'UPDATE Mission_type
        SET 
        mission_type_id = :id,
        mission_type_name = :name
        WHERE mission_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbMissionTypes(): int
    {
        // Nb Mission types request
        $sql = 'SELECT COUNT(*) AS nbMissionTypes FROM Mission_type';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbMissionTypes = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbMissionTypes = (int)$result['nbMissionTypes'];
            }
        }
        return $nbMissionTypes;
    }
}
