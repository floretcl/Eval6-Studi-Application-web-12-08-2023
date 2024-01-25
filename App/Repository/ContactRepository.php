<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Database\DatabaseConnection;
use PDO;

class ContactRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getContactsWithPagination(string $search, int $start, int $perPage): array
    {
        // Contacts request
        $sql = 'SELECT 
        contact_uuid AS uuid,
        contact_code_name AS codeName,
        contact_firstname AS firstName,
        contact_lastname AS lastName,
        contact_birthday AS birthday,
        contact_nationality AS nationality
        FROM Contact
        WHERE contact_code_name LIKE :search
        ORDER BY contact_code_name
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $contacts = [];
        if ($statement->execute()) {
            while ($contact = $statement->fetchObject('\App\Entity\Contact')) {
                $contacts[] = $contact;
            }
        }
        return $contacts;
    }

    public function getPaginationForContacts(int $perPage, string $search): array
    {
        // Nb Contacts request & pagination
        $sql = 'SELECT COUNT(*) AS nbContacts 
        FROM Contact
        WHERE contact_code_name LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbContacts = (int)$result['nbContacts'];
            }
            $nbPages = ceil($nbContacts / $perPage);
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

    public function getContacts(): array
    {
        // Contacts request
        $sql = 'SELECT 
        contact_uuid AS uuid,
        contact_code_name AS codeName,
        contact_firstname AS firstName,
        contact_lastname AS lastName,
        contact_birthday AS birthday,
        contact_nationality AS nationality
        FROM Contact';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $contacts = [];
        if ($statement->execute()) {
            while ($contact = $statement->fetchObject('\App\Entity\Contact')) {
                $contacts[] = $contact;
            }
        }
        return $contacts;
    }

    public function getContact(string $uuid): Contact
    {
        // Contact request
        $sql = 'SELECT 
        contact_uuid AS uuid,
        contact_code_name AS codeName,
        contact_firstname AS firstName,
        contact_lastname AS lastName,
        contact_birthday AS birthday,
        contact_nationality AS nationality
        FROM Contact
        WHERE contact_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $contact = new Contact();
        if ($statement->execute()) {
            $contact = $statement->fetchObject('\App\Entity\Contact');
        }
        return $contact;
    }

    public function insertContact(string $codeName, string $firstname, string $lastname, string $birthday, string $nationality): bool
    {
        // Contact add request
        $sql = 'INSERT INTO Contact (
          contact_code_name,
          contact_firstname,
          contact_lastname,
          contact_birthday,
          contact_nationality
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

    public function deleteContact(string $uuid): bool
    {
        // Delete contact request
        $sql = 'DELETE 
          FROM Contact 
          WHERE Contact.contact_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateContact(string $uuid, string $codeName, string $firstname, string $lastname, string $birthday, string $nationality): bool
    {

        // Contact update request
        $sql = 'UPDATE Contact
        SET 
        contact_code_name = :codename,
        contact_firstname = :firstname,
        contact_lastname = :lastname,
        contact_birthday = :birthday,
        contact_nationality = :nationality
        WHERE contact_uuid = :uuid';
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

    public function getNbContacts(): int
    {
        // Nb Contacts request
        $sql = 'SELECT COUNT(*) AS nbContacts FROM Contact';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbContacts = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbContacts = (int)$result['nbContacts'];
            }
        }
        return $nbContacts;
    }

    public function getContactsFromMission(string $missionUuid): array
    {
        $sql = 'SELECT
        Contact.contact_uuid AS uuid,
        Contact.contact_code_name AS codeName,
        Contact.contact_firstname AS firstName,
        Contact.contact_lastname AS lastName,
        Contact.contact_birthday AS birthday,
        Contact.contact_nationality AS nationality
        FROM Mission_Contact
        INNER JOIN Contact ON Contact.contact_uuid = Mission_Contact.contact_uuid
        WHERE mission_uuid = :missionUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':missionUuid', $missionUuid, PDO::PARAM_STR);

        $contacts = [];
        if ($statement->execute()) {
            while ($contact = $statement->fetchObject('\App\Entity\Contact')) {
                $contacts[] = $contact;
            }
        }
        return $contacts;
    }

    public function getContactsUUIDFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        Contact.contact_uuid AS uuid
        FROM (Mission_Contact
        INNER JOIN Contact ON Contact.contact_uuid = Mission_Contact.contact_uuid)
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

    public function getContactNationality(string $uuid): string
    {
        $sql = 'SELECT
        contact_nationality AS nationality
        FROM Contact
        WHERE contact_uuid = :contactUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':contactUuid', $uuid, PDO::PARAM_STR);

        $contactNationality = '';
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $contactNationality = $result['nationality'];;
            }
        }
        return $contactNationality;
    }
}
