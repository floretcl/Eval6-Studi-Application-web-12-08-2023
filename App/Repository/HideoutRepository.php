<?php

namespace App\Repository;

use App\Entity\Hideout;
use App\Database\DatabaseConnection;
use PDO;

class HideoutRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getHideoutsWithPagination(string $search, int $start, int $perPage): array
    {
        // Hideouts request
        $sql = 'SELECT 
        hideout_uuid AS uuid,
        hideout_code_name AS codeName,
        hideout_address AS address,
        hideout_country AS country,
        Hideout_type.hideout_type_name AS hideoutType
        FROM (Hideout
        INNER JOIN Hideout_type ON Hideout.hideout_type = Hideout_type.hideout_type_id)
        WHERE hideout_code_name LIKE :search
        ORDER BY hideout_code_name
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $hideouts = [];
        if ($statement->execute()) {
            while ($hideout = $statement->fetchObject('\App\Entity\Hideout')) {
                $hideouts[] = $hideout;
            }
        }
        return $hideouts;
    }

    public function getPaginationForHideouts(int $perPage, string $search): array
    {
        // Nb Hideouts request & pagination
        $sql = 'SELECT COUNT(*) AS nbHideouts 
        FROM Hideout
        WHERE hideout_code_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbHideouts = (int)$result['nbHideouts'];
            }
            $nbPages = ceil($nbHideouts / $perPage);
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

    public function getHideouts(): array
    {
        // Hideouts request
        $sql = 'SELECT 
        hideout_uuid AS uuid,
        hideout_code_name AS codeName,
        hideout_address AS address,
        hideout_country AS country,
        hideout_type AS hideoutType
        FROM Hideout';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $hideouts = [];
        if ($statement->execute()) {
            while ($hideout = $statement->fetchObject('\App\Entity\Hideout')) {
                $hideouts[] = $hideout;
            }
        }
        return $hideouts;
    }

    public function getHideout(string $uuid): Hideout
    {
        // Hideout request
        $sql = 'SELECT 
        hideout_uuid AS uuid,
        hideout_code_name AS codeName,
        hideout_address AS address,
        hideout_country AS country,
        Hideout_type.hideout_type_name AS hideoutType
        FROM (Hideout
        INNER JOIN Hideout_type ON Hideout.hideout_type = Hideout_type.hideout_type_id)
        WHERE hideout_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $hideout = new Hideout();
        if ($statement->execute()) {
            $hideout = $statement->fetchObject('\App\Entity\Hideout');
        }
        return $hideout;
    }

    public function insertHideout(string $codeName, string $address, string $country, string $type): bool
    {
        // Hideout add request
        $sql = 'INSERT INTO Hideout (
          hideout_code_name,
          hideout_address,
          hideout_country,
          hideout_type
        ) VALUES (
          :codename,
          :address,
          :country,
          :type
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':codename', $codeName, PDO::PARAM_STR);
        $statement->bindParam(':address', $address, PDO::PARAM_STR);
        $statement->bindParam(':country', $country, PDO::PARAM_STR);
        $statement->bindParam(':type', $type, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteHideout(string $uuid): bool
    {
        // Delete hideout request
        $sql = 'DELETE 
        FROM Hideout 
        WHERE hideout_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateHideout(string $uuid, string $codeName, string $address, string $country, string $type): bool
    {
        // Hideout update request
        $sql = 'UPDATE Hideout
        SET 
        hideout_code_name = :codename,
        hideout_address = :address,
        hideout_country = :country,
        hideout_type = :type
        WHERE hideout_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $statement->bindParam(':codename', $codeName, PDO::PARAM_STR);
        $statement->bindParam(':address', $address, PDO::PARAM_STR);
        $statement->bindParam(':country', $country, PDO::PARAM_STR);
        $statement->bindParam(':type', $type, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbHideouts(): int
    {
        // Nb Hideouts request
        $sql = 'SELECT COUNT(*) AS nbHideouts FROM Hideout';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbHideouts = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbHideouts = (int)$result['nbHideouts'];
            }
        }
        return $nbHideouts;
    }

    public function getHideoutsFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        Hideout.hideout_uuid AS uuid,
        Hideout.hideout_code_name AS codeName,
        Hideout.hideout_address AS address,
        Hideout.hideout_country AS country,
        Hideout_type.hideout_type_name AS hideoutType
        FROM ((Mission_Hideout
        INNER JOIN Hideout ON Hideout.hideout_uuid = Mission_Hideout.hideout_uuid)
        INNER JOIN Hideout_type ON Hideout_type.hideout_type_id = Hideout.hideout_type)
        WHERE mission_uuid = :missionUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':missionUuid', $missionUuid, PDO::PARAM_STR);

        $hideouts = [];
        if ($statement->execute()) {
            while ($hideout = $statement->fetchObject('\App\Entity\Hideout')) {
                $hideouts[] = $hideout;
            }
        }
        return $hideouts;
    }

    public function getHideoutsUUIDFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        Hideout.hideout_uuid AS uuid
        FROM (Mission_Hideout
        INNER JOIN Hideout ON Hideout.hideout_uuid = Mission_Hideout.hideout_uuid)
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

    public function getHideoutCountry(string $uuid): string
    {
        $sql = 'SELECT
        hideout_country AS country
        FROM Hideout
        WHERE hideout_uuid = :hideoutUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':hideoutUuid', $uuid, PDO::PARAM_STR);

        $hideoutCountry = '';
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $hideoutCountry = $result['country'];;
            }
        }
        return $hideoutCountry;
    }
}
