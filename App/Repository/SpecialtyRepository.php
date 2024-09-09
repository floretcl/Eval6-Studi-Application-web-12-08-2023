<?php

namespace App\Repository;

use App\Entity\Specialty;
use App\Database\DatabaseConnection;
use PDO;

class SpecialtyRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getSpecialtiesWithPagination(string $search, int $start, int $perPage): array
    {
        //  Specialties request
        $sql = 'SELECT 
        specialty_id AS id,
        specialty_name AS name
        FROM Specialty
        WHERE specialty_name LIKE :search
        ORDER BY specialty_id
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $specialties = [];
        if ($statement->execute()) {
            while ($specialty = $statement->fetchObject('\App\Entity\Specialty')) {
                $specialties[] = $specialty;
            }
        }
        return $specialties;
    }

    public function getPaginationForSpecialties(int $perPage, string $search): array
    {
        // Nb Specialties request & pagination
        $sql = 'SELECT COUNT(*) AS nbSpecialties 
        FROM Specialty
        WHERE specialty_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbSpecialties = (int)$result['nbSpecialties'];
            }
            $nbPages = ceil($nbSpecialties / $perPage);
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

    public function getSpecialties(): array
    {
        // Specialties request
        $sql = 'SELECT
        specialty_id AS id,
        specialty_name AS name
        FROM Specialty';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $specialties = [];
        if ($statement->execute()) {
            while($specialty = $statement->fetchObject('\App\Entity\Specialty')) {
                $specialties[] = $specialty;
            }
        }
        return $specialties;
    }

    public function getSpecialty(int $id): Specialty
    {
        // Specialty request
        $sql = 'SELECT 
        specialty_id AS id,
        specialty_name AS name
        FROM Specialty
        WHERE specialty_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        $specialty = new Specialty();
        if ($statement->execute()) {
            $specialty = $statement->fetchObject('\App\Entity\Specialty');
        }
        return $specialty;
    }

    public function insertSpecialty(string $name): bool
    {
        //  add request
        $sql = 'INSERT INTO Specialty (
          specialty_name
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

    public function deleteSpecialty(int $specialtyId): bool
    {
        // Delete Specialty request
        $sql = 'DELETE 
          FROM Specialty 
          WHERE specialty_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $specialtyId, PDO::PARAM_INT);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateSpecialty(int $specialtyId, string $specialtyName): bool
    {
        // Specialty update request
        $sql = 'UPDATE Specialty
        SET 
        specialty_id = :id,
        specialty_name = :name
        WHERE specialty_id = :id';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':id', $specialtyId, PDO::PARAM_STR);
        $statement->bindParam(':name', $specialtyName, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbSpecialties(): int
    {
        // Nb Specialties request
        $sql = 'SELECT COUNT(*) AS nbSpecialties FROM Specialty';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbSpecialties = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbSpecialties = (int)$result['nbSpecialties'];
            }
        }
        return $nbSpecialties;
    }
}
