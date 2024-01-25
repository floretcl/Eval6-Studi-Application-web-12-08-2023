<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use PDO;

class MissionHideoutRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getMissionsHideout(string $hideoutUUID): array
    {
        // Hideout missions request
        $sql = 'SELECT
        mission_uuid AS missionUuid
        FROM (Mission_Hideout
        INNER JOIN Hideout ON Mission_Hideout.hideout_uuid = Hideout.hideout_uuid)
        WHERE Mission_Hideout.hideout_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $hideoutUUID, PDO::PARAM_STR);

        $missionsHideout = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $missionsHideout[] = $result['missionUuid'];
            }
        }
        return $missionsHideout;
    }

    public function insertMissionHideout(string $hideoutCodeName, string $missionUUID): bool
    {
        // Hideout mission insert request
        $sql = 'INSERT INTO Mission_Hideout (
        hideout_uuid,
        mission_uuid
        ) VALUES (
        (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = :hideout_codename),
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':hideout_codename', $hideoutCodeName, PDO::PARAM_STR);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function insertMissionsHideout(string $hideoutUUID, array $missions): bool
    {
        // Hideout missions insert request
        $sql = 'INSERT INTO Mission_Hideout (
        hideout_uuid,
        mission_uuid
        ) VALUES (
        :hideout_uuid,
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($missions as $mission) {
            if ($mission != '') {
                $statement->bindParam(':hideout_uuid', $hideoutUUID, PDO::PARAM_STR);
                $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                $success = false;
                if ($statement->execute()) {
                    $success = true;
                }
            }
        }
        return $success;
    }

    public function insertMissionHideouts(array $hideouts, string $missionCodeName): bool
    {
        // Mission Hideouts insert request
        $sql = 'INSERT INTO Mission_Hideout (
            mission_uuid,
            hideout_uuid
        ) VALUES (
            (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
            :hideout_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($hideouts as $hideout) {
            $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
            $statement->bindParam(':hideout_uuid', $hideout, PDO::PARAM_STR);
            $success = false;
            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function deleteMissionsHideout(string $hideoutUUID): bool
    {
        // Mission_Hideout delete request
        $sql = 'DELETE FROM Mission_Hideout
        WHERE hideout_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $hideoutUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function deleteMissionHideouts(string $missionUUID): bool
    {
        // Mission_Hideout delete request
        $sql = 'DELETE FROM Mission_Hideout
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
