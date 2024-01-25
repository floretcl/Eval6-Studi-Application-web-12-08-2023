<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use PDO;

class MissionTargetRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    function getMissionsTarget(string $targetUUID): array
    {
        // Target missions request
        $sql = 'SELECT
        mission_uuid AS missionUuid
        FROM (Mission_Target
        INNER JOIN Target ON Mission_Target.target_uuid = Target.target_uuid)
        WHERE Mission_Target.target_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $targetUUID, PDO::PARAM_STR);

        $missionsTarget = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $missionsTarget[] = $result['missionUuid'];
            }
        }
        return $missionsTarget;
    }

    function insertMissionTarget(string $targetCodeName, string $missionUUID): bool
    {
        // Target mission insert request
        $sql = 'INSERT INTO Mission_Target (
        target_uuid,
        mission_uuid
        ) VALUES (
        (SELECT target_uuid FROM Target WHERE target_code_name = :target_codename),
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':target_codename', $targetCodeName, PDO::PARAM_STR);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    function insertMissionsTarget(string $targetUUID, array $missions): bool
    {
        // Target mission insert request
        $sql = 'INSERT INTO Mission_Target (
        target_uuid,
        mission_uuid
        ) VALUES (
        :target_uuid,
        :mission_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($missions as $mission) {
            if ($mission != '') {
                $statement->bindParam(':target_uuid', $targetUUID, PDO::PARAM_STR);
                $statement->bindParam(':mission_uuid', $mission, PDO::PARAM_STR);
                $success = false;
                if ($statement->execute()) {
                    $success = true;
                }
            }
        }
        return $success;
    }

    function insertMissionTargets(array $targets, string $missionCodeName): bool
    {
        // Mission_Target insert request
        $sql = 'INSERT INTO Mission_Target (
            mission_uuid,
            target_uuid
        ) VALUES (
            (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name),
            :target_uuid
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($targets as $target) {
            $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
            $statement->bindParam(':target_uuid', $target, PDO::PARAM_STR);
            $success = false;
            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    function deleteMissionsTarget(string $targetUUID): bool
    {
        // Mission_Target delete request
        $sql = 'DELETE FROM Mission_Target
        WHERE target_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $targetUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    function deleteMissionTargets(string $missionUUID): bool
    {
        // Mission_Target delete request
        $sql = 'DELETE FROM Mission_Target
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
