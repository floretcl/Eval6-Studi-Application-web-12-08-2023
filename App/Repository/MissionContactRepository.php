<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use PDO;

class MissionContactRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getMissionsContact(string $contactUUID): array
    {
        // Contact missions request
        $sql = 'SELECT
        mission_uuid AS missionUuid
        FROM (Mission_Contact
        INNER JOIN Contact ON Mission_Contact.contact_uuid = Contact.contact_uuid)
        WHERE Mission_Contact.contact_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $contactUUID, PDO::PARAM_STR);

        $missionsContact = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $missionsContact[] = $result['missionUuid'];
            }
        }
        return $missionsContact;
    }

    public function insertMissionContact(string $contactCodeName, string $missionUUID): bool
    {
        // Contact mission insert request
        $sql = 'INSERT INTO Mission_Contact (
        contact_uuid,
        mission_uuid
        ) VALUES (
        (SELECT contact_uuid FROM Contact WHERE contact_code_name = :contact_codename),
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':contact_codename', $contactCodeName, PDO::PARAM_STR);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function insertMissionsContact(string $contactUUID, array $missions): bool
    {
        // Contact mission insert request
        $sql = 'INSERT INTO Mission_Contact (
        contact_uuid,
        mission_uuid
        ) VALUES (
        :contact_uuid,
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($missions as $mission) {
            if ($mission != '') {
                $statement->bindParam(':contact_uuid', $contactUUID, PDO::PARAM_STR);
                $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                $success = false;
                if ($statement->execute()) {
                    $success = true;
                }
            }
        }
        return $success;
    }

    public function insertMissionContacts(array $contacts, string $missionCodeName): bool
    {
        // Mission_Contact insert request
        $sql = 'INSERT INTO Mission_Contact (
            mission_uuid,
            contact_uuid
        ) VALUES (
            (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
            :contact_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($contacts as $contact) {
            $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
            $statement->bindParam(':contact_uuid', $contact, PDO::PARAM_STR);
            $success = false;
            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function deleteMissionsContact(string $contactUUID): bool
    {
        // Mission_Contact delete request
        $sql = 'DELETE FROM Mission_Contact
        WHERE contact_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $contactUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteMissionContacts(string $missionUUID): bool
    {
        // Mission_Contact delete request
        $sql = 'DELETE FROM Mission_Contact
        WHERE mission_uuid = :mission_uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }
}
