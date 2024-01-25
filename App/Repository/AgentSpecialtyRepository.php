<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use PDO;

class AgentSpecialtyRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getAgentSpecialties(string $agentUUID): array
    {
        // Agent Specialties request
        $sql = 'SELECT
        specialty_name AS specialtyName
        FROM (Agent_Specialty
        INNER JOIN Specialty ON Specialty.specialty_id = Agent_Specialty.specialty_id)
        WHERE agent_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $agentUUID, PDO::PARAM_STR);

        $agentSpecialties = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $agentSpecialties[] = $result['specialtyName'];
            }
        }
        return $agentSpecialties;
    }

    public function insertAgentSpecialty(string $agentCode, int $specialtyId): bool
    {
        // Agent_Specialty insert request
        $sql = 'INSERT INTO Agent_Specialty (
        agent_uuid,
        specialty_id
        ) VALUES (
        (SELECT agent_uuid FROM Agent WHERE agent_code = :agent_code),
        :specialty_id
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':agent_code', $agentCode, PDO::PARAM_STR);
        $statement->bindParam(':specialty_id', $specialtyId, PDO::PARAM_INT);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function insertAgentSpecialties(string $agentUUID, array $specialties): bool
    {
        // Agent_Specialty insert request
        $sql = 'INSERT INTO Agent_Specialty (
        agent_uuid,
        specialty_id
        ) VALUES (
        :agent_uuid,
        :specialty_id
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = true;
        foreach ($specialties as $specialty) {
            $statement->bindParam(':agent_uuid', $agentUUID, PDO::PARAM_STR);
            $statement->bindParam(':specialty_id', $specialty, PDO::PARAM_STR);
            $success = false;
            if ($statement->execute()) {
                $success = true;
            } else {
                $errorInfo = $statement->errorInfo();
                $this->errorLog->writeErrorLog($errorInfo);
            }
        }
        return $success;
    }

    public function deleteAgentSpecialties(string $agentUUID): bool
    {
        // Agent_Specialty delete request
        $sql = 'DELETE FROM Agent_Specialty
        WHERE agent_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $agentUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }
}
