<?php

namespace App\Repository;

use App\Entity\Admin;
use App\Database\DatabaseConnection;
use PDO;

class AdminRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getAdminsWithPagination(string $search, int $start, int $perPage): array
    {
        // Admins request
        $sql = 'SELECT
        admin_uuid AS uuid,
        admin_firstname AS firstName,
        admin_lastname AS lastName,
        admin_email AS email,
        admin_password AS passwordHash,
        admin_creation_date AS creationDate
        FROM Admin
        WHERE admin_email LIKE :search
        ORDER BY admin_creation_date
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $admins = [];
        if ($statement->execute()) {
            while ($admin = $statement->fetchObject('\App\Entity\Admin')) {
                $admins[] = $admin;
            }
        }
        return $admins;
    }

    public function getPaginationForAdmins(int $perPage, string $search): array
    {
        // Nb Admins request
        $sql = 'SELECT COUNT(*) AS nbAdmins
        FROM Admin
        WHERE admin_email LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbAdmins = (int)$result['nbAdmins'];
            }
            $nbPages = ceil($nbAdmins / $perPage);
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

    public function getAdmin(string $uuid): Admin
    {
        // Admin request
        $sql = 'SELECT
        admin_uuid AS uuid,
        admin_firstname AS firstName,
        admin_lastname AS lastName,
        admin_email AS email,
        admin_password AS passwordHash,
        admin_creation_date AS creationDate
        FROM Admin
        WHERE admin_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $admin = new Admin();
        if ($statement->execute()) {
            $admin = $statement->fetchObject('\App\Entity\Admin');
        }
        return $admin;
    }

    public function insertAdmin(string $firstname, string $lastname, string $email, string $passwordHash): bool
    {
        // Admin add request
        $sql = 'INSERT INTO Admin (
        admin_firstname,
        admin_lastname,
        admin_email,
        admin_password
        ) VALUES (
        :firstname,
        :lastname,
        :email,
        :passwordHash
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteAdmin(string $uuid): bool
    {
        // Delete admin request
        $sql = 'DELETE
        FROM Admin
        WHERE admin_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateAdmin(string $uuid, string $firstname, string $lastname, string $email): bool
    {
        // Admin update request
        $sql = 'UPDATE Admin
        SET
        admin_firstname = :firstname,
        admin_lastname = :lastname,
        admin_email = :email
        WHERE admin_uuid = :uuid LIMIT 1';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbAdmins(): int
    {
    // Nb Admins request
        $sql = 'SELECT COUNT(*) AS nbAdmins FROM Admin';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbAdmins = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbAdmins = (int)$result['nbAdmins'];
            }
        }
        return $nbAdmins;
    }

    public function verifyAdmin(string $email, string $password): string
    {
        $sql = 'SELECT
        admin_uuid AS uuid,
        admin_firstname AS firstName,
        admin_lastname AS lastName,
        admin_email AS email,
        admin_password AS passwordHash,
        admin_creation_date AS creationDate
        FROM Admin WHERE admin_email = :email';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $message = "Error: invalid identifiers";
        if ($statement->execute()) {
            while ($admin = $statement->fetchObject('\App\Entity\Admin')) {
                $hash = $admin->getPasswordHash();
                // To hash password : $options = array('cost' => 11);
                if (password_verify($password, $hash)) {
                    $message = "Valid identifiers";
                }
            }
        }
        return $message;
    }

    public function getAdminUuid(string $email): string
    {
        $sql = 'SELECT
        admin_uuid AS uuid
        FROM Admin WHERE admin_email = :email';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $uuid = '';
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $uuid = $result['uuid'];
            }
        }
        return $uuid;
    }
}
