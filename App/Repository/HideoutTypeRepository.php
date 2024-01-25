<?php

namespace App\Repository;

use App\Entity\HideoutType;
use App\Database\DatabaseConnection;
use PDO;

class HideoutTypeRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getHideoutTypesWithPagination(string $search, int $start, int $perPage): array
    {
        // Hideout Types request
        $sql = 'SELECT 
        hideout_type_id AS id,
        hideout_type_name AS name
        FROM Hideout_type
        WHERE hideout_type_name LIKE :search
        ORDER BY hideout_type_id
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $hideoutTypes = [];
        if ($statement->execute()) {
            while ($hideoutType = $statement->fetchObject('\App\Entity\HideoutType')) {
                $hideoutTypes[] = $hideoutType;
            }
        }
        return $hideoutTypes;
    }

    public function getPaginationForHideoutTypes(int $perPage, string $search): array
    {
        // Nb Hideout Types request & pagination
        $sql = 'SELECT COUNT(*) AS nbHideoutTypes 
        FROM Hideout_type
        WHERE hideout_type_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbHideoutTypes = (int) $result['nbHideoutTypes'];
            }
            $nbPages = ceil($nbHideoutTypes / $perPage);
            if(!empty($_GET['page'])){
                $currentPage = (int) strip_tags($_GET['page']);
            } else {
                $currentPage = 1;
            }
            $start = ($currentPage * $perPage) - $perPage;
            $pagination = ['perPage' => $perPage, 'nbPages' => $nbPages, 'currentPage' => $currentPage, 'start' => $start];
        }
        return $pagination;
    }

    public function getHideoutTypes(): array
    {
        $sql = 'SELECT 
        hideout_type_id AS id,
        hideout_type_name AS name
        FROM Hideout_type';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $hideoutTypes = [];
        if ($statement->execute()) {
            while ($type = $statement->fetchObject('\App\Entity\HideoutType')) {
                $hideoutTypes[] = $type;
            }
        }
        return $hideoutTypes;
    }

    public function getHideoutType(int $id): HideoutType
    {
        // Hideout type request
        $sql = 'SELECT 
        hideout_type_id AS id,
        hideout_type_name AS name
        FROM Hideout_type
        WHERE hideout_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        $hideoutType = new HideoutType();
        if ($statement->execute()) {
            $hideoutType = $statement->fetchObject('\App\Entity\HideoutType');
        }
        return $hideoutType;
    }

    public function insertHideoutType(string $name): bool
    {
        //  add request
        $sql = 'INSERT INTO Hideout_type (
          hideout_type_name
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

    public function deleteHideoutType(int $id): bool
    {
        // Delete hideout type request
        $sql = 'DELETE 
          FROM Hideout_type 
          WHERE hideout_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateHideoutType(int $id, string $name): bool
    {
        // Hideout type update request
        $sql = 'UPDATE Hideout_type
        SET 
        hideout_type_id = :id,
        hideout_type_name = :name
        WHERE hideout_type_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbHideoutTypes(): int
    {
        // Nb Hideout types request
        $sql = 'SELECT COUNT(*) AS nbHideoutTypes FROM Hideout_type';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbHideoutTypes = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbHideoutTypes = (int)$result['nbHideoutTypes'];
            }
        }
        return $nbHideoutTypes;
    }
}
