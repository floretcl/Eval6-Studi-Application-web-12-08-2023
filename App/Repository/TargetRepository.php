<?php

namespace App\Repository;

use App\Entity\Target;
use App\Database\DatabaseConnection;
use PDO;

class TargetRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getTargetsWithPagination(string $search, int $start, int $perPage): array
    {
        // Targets request
        $sql = 'SELECT 
        target_uuid AS uuid,
        target_code_name AS codeName,
        target_firstname AS firstName,
        target_lastname AS lastName,
        target_birthday AS birthday,
        target_nationality AS nationality
        FROM Target
        WHERE target_code_name LIKE :search
        ORDER BY target_code_name
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $targets = [];
        if ($statement->execute()) {
            while ($target = $statement->fetchObject('\App\Entity\Target')) {
                $targets[] = $target;
            }
        }
        return $targets;
    }

    public function getPaginationForTargets(int $perPage, string $search): array
    {
        // Nb Targets request & pagination
        $sql = 'SELECT COUNT(*) AS nbTargets 
        FROM Target
        WHERE target_code_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbTargets = (int)$result['nbTargets'];
            }
            $nbPages = ceil($nbTargets / $perPage);
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

    public function getTargets(): array
    {
        // Targets request
        $sql = 'SELECT 
        target_uuid AS uuid,
        target_code_name AS codeName,
        target_firstname AS firstName,
        target_lastname AS lastName,
        target_birthday AS birthday,
        target_nationality AS nationality
        FROM Target';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $targets = [];
        if ($statement->execute()) {
            while ($target = $statement->fetchObject('\App\Entity\Target')) {
                $targets[] = $target;
            }
        }
        return $targets;
    }

    public function getTarget(string $uuid): Target
    {
        // Target request
        $sql = 'SELECT 
        target_uuid AS uuid,
        target_code_name AS codeName,
        target_firstname AS firstName,
        target_lastname AS lastName,
        target_birthday AS birthday,
        target_nationality AS nationality
        FROM Target
        WHERE target_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $target = new Target();
        if ($statement->execute()) {
            $target = $statement->fetchObject('\App\Entity\Target');
        }
        return $target;
    }

    public function insertTarget(string $codeName, string $firstname, string $lastname, string $birthday, string $nationality): bool
    {
        // Target add request
        $sql = 'INSERT INTO Target (
          target_code_name,
          target_firstname,
          target_lastname,
          target_birthday,
          target_nationality
        ) VALUES (
          :codename,
          :firstname,
          :lastname,
          :birthday,
          :nationality
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':codename', $codeName, PDO::PARAM_STR);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $statement->bindParam(':nationality', $nationality, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteTarget(string $uuid): bool
    {
        // Delete target request
        $sql = 'DELETE 
          FROM Target 
          WHERE Target.target_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateTarget(string $uuid, string $codeName, string $firstname, string $lastname, string $birthday, string $nationality): bool
    {
        // Target update request
        $sql = 'UPDATE Target
        SET 
        target_code_name = :codename,
        target_firstname = :firstname,
        target_lastname = :lastname,
        target_birthday = :birthday,
        target_nationality = :nationality
        WHERE target_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $statement->bindParam(':codename', $codeName, PDO::PARAM_STR);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $statement->bindParam(':nationality', $nationality, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbTargets(): int
    {
        // Nb Targets request
        $sql = 'SELECT COUNT(*) AS nbTargets FROM Target';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbTargets = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbTargets = (int)$result['nbTargets'];
            }
        }
        return $nbTargets;
    }

    public function getTargetsFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        Target.target_uuid AS uuid,
        Target.target_code_name AS codeName,
        Target.target_firstname AS firstName,
        Target.target_lastname AS lastName,
        Target.target_birthday AS birthday,
        Target.target_nationality AS nationality
        FROM Mission_Target
        INNER JOIN Target ON Target.target_uuid = Mission_Target.target_uuid
        WHERE mission_uuid = :missionUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':missionUuid', $missionUuid, PDO::PARAM_STR);

        $targets = [];
        if ($statement->execute()) {
            while ($target = $statement->fetchObject('\App\Entity\Target')) {
                $targets[] = $target;
            }
        }
        return $targets;
    }

    public function getTargetsUUIDFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        Target.target_uuid AS uuid
        FROM (Mission_Target
        INNER JOIN Target ON Target.target_uuid = Mission_Target.target_uuid)
        WHERE mission_uuid = :missionUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':missionUuid', $missionUuid, PDO::PARAM_STR);

        $codenames = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $codenames[] = $result['uuid'];;
            }
        }
        return $codenames;
    }

    public function getTargetNationality(string $uuid): string
    {
        $sql = 'SELECT
        target_nationality AS nationality
        FROM Target
        WHERE target_uuid = :targetUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':targetUuid', $uuid, PDO::PARAM_STR);

        $targetNationality = '';
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $targetNationality = $result['nationality'];;
            }
        }
        return $targetNationality;
    }
}
