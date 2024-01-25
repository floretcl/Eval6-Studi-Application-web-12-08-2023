<?php

namespace App\Repository;

use App\Entity\Agent;
use App\Database\DatabaseConnection;
use PDO;

class AgentRepository
{
    public DatabaseConnection $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DatabaseConnection();
    }

    public function getAgentsWithPagination(string $search, int $start, int $perPage): array
    {
        // Agents request
        $sql = 'SELECT 
        agent_uuid AS uuid,
        agent_code AS code,
        agent_firstname AS firstName,
        agent_lastname AS lastName,
        agent_birthday AS birthday,
        agent_nationality AS nationality
        FROM Agent
        WHERE agent_code LIKE :search
        ORDER BY agent_code
        LIMIT :start, :perPage';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $statement->bindParam(':start', $start, PDO::PARAM_INT);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);

        $agents = [];
        if ($statement->execute()) {
            while ($agent = $statement->fetchObject('\App\Entity\Agent')) {
                $agents[] = $agent;
            }
        }
        return $agents;
    }

    public function getPaginationForAgents(int $perPage, string $search): array
    {
        // Nb Agents request & pagination
        $sql = 'SELECT COUNT(*) AS nbAgents 
        FROM Agent
        WHERE agent_code LIKE :search';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        $pagination = [];
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbAgents = (int)$result['nbAgents'];
            }
            $nbPages = ceil($nbAgents / $perPage);
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

    public function getAgents(): array
    {
        // Agents request
        $sql = 'SELECT 
        agent_uuid AS uuid,
        agent_code AS code,
        agent_firstname AS firstName,
        agent_lastname AS lastName,
        agent_birthday AS birthday,
        agent_nationality AS nationality
        FROM Agent';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $agents = [];
        if ($statement->execute()) {
            while ($agent = $statement->fetchObject('\App\Entity\Agent')) {
                $agents[] = $agent;
            }
        }
        return $agents;
    }

    public function getAgent(string $uuid): Agent
    {
        // Agent request
        $sql = 'SELECT 
        agent_uuid AS uuid,
        agent_code AS code,
        agent_firstname AS firstName,
        agent_lastname AS lastName,
        agent_birthday AS birthday,
        agent_nationality AS nationality,
        agent_mission AS mission
        FROM Agent
        WHERE agent_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $agent = new Agent();
        if ($statement->execute()) {
            $agent = $statement->fetchObject('\App\Entity\Agent');
        }
        return $agent;
    }

    public function insertAgent(string $code, string $firstname, string $lastname, string $birthday, string $nationality, array $specialties): bool
    {
        // Agent add request
        $sql = 'INSERT INTO Agent (
          agent_code,
          agent_firstname,
          agent_lastname,
          agent_birthday,
          agent_nationality
        ) VALUES (
          :code,
          :firstname,
          :lastname,
          :birthday,
          :nationality
        )';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':code', $code, PDO::PARAM_STR);
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $statement->bindParam(':nationality', $nationality, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
            // Add one or more specialty
            foreach ($specialties as $specialty) {
                $agentSpecialtyRepository = new AgentSpecialtyRepository();
                $success = $agentSpecialtyRepository->insertAgentSpecialty($code, $specialty);
            }
        }
        return $success;
    }

    public function deleteAgent(string $uuid): bool
    {
        // Delete agent request
        $sql = 'DELETE
        FROM Agent
        WHERE agent_uuid = :uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateAgent(string $uuid, string $code, string $firstname, string $lastname, string $birthday, string $nationality, array $specialties): bool
    {
        $agentSpecialtyRepository = new AgentSpecialtyRepository();
        $success = $agentSpecialtyRepository->deleteAgentSpecialties($uuid);

        if ($success && !empty($specialties)) {
            $success = $agentSpecialtyRepository->insertAgentSpecialties($uuid, $specialties);
        }

        if ($success) {
            // Agent update request
            $sql = 'UPDATE Agent
            SET 
            agent_code = :code,
            agent_firstname = :firstname,
            agent_lastname = :lastname,
            agent_birthday = :birthday,
            agent_nationality = :nationality
            WHERE agent_uuid = :uuid';
            $statement = $this->dbConnection->dbConnect()->prepare($sql);
            $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
            $statement->bindParam(':code', $code, PDO::PARAM_STR);
            $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $statement->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $statement->bindParam(':nationality', $nationality, PDO::PARAM_STR);

            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function updateAgentMission(string $agentCode, string $missionUUID): bool
    {
        $sql = 'UPDATE Agent
        SET agent_mission = :mission_uuid
        WHERE agent_uuid = (SELECT agent_uuid FROM Agent WHERE agent_code = :agent_code)';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':agent_code', $agentCode, PDO::PARAM_STR);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);

        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function updateAgentsMission(array $agents, string $missionCodeName): bool
    {
        $sql = 'UPDATE Agent
        SET agent_mission = (SELECT mission_uuid FROM Mission WHERE mission_code_name = :mission_code_name)
        WHERE agent_uuid = :agent_uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $success = false;
        foreach ($agents as $agent) {
            $statement->bindParam(':mission_code_name', $missionCodeName, PDO::PARAM_STR);
            $statement->bindParam(':agent_uuid', $agent, PDO::PARAM_STR);

            if ($statement->execute()) {
                $success = true;
            }
        }
        return $success;
    }

    public function removeAgentMission(string $missionUUID): bool
    {
        // Agent mission update request
        $sql = 'UPDATE Agent
        SET agent_mission = NULL
        WHERE agent_mission = :mission_uuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':mission_uuid', $missionUUID, PDO::PARAM_STR);
        $success = false;
        if ($statement->execute()) {
            $success = true;
        }
        return $success;
    }

    public function getNbAgents(): int
    {
        // Nb Agents request
        $sql = 'SELECT COUNT(*) AS nbAgents FROM Agent';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);

        $nbAgents = 0;
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nbAgents = (int)$result['nbAgents'];
            }
        }
        return $nbAgents;
    }

    public function getAgentsFromMission(string $missionUuid): array
    {
        $sql = 'SELECT 
        agent_uuid AS uuid,
        agent_code AS code,
        agent_firstname AS firstName,
        agent_lastname AS lastName,
        agent_birthday AS birthday,
        agent_nationality AS nationality,
        agent_mission AS mission
        FROM Agent
        WHERE agent_mission = :missionUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':missionUuid', $missionUuid, PDO::PARAM_STR);

        $agents = [];
        if ($statement->execute()) {
            while ($agent = $statement->fetchObject('\App\Entity\Agent')) {
                $agents[] = $agent;
            }
        }
        return $agents;
    }

    public function getAgentsUUIDFromMission(string $missionUuid): array
    {
        $sql = 'SELECT
        agent_uuid AS uuid
        FROM Agent
        WHERE agent_mission = :missionUuid';
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

    public function getAgentNationality(string $uuid): string
    {
        $sql = 'SELECT
        agent_nationality AS nationality
        FROM Agent
        WHERE agent_uuid = :agentUuid';
        $statement = $this->dbConnection->dbConnect()->prepare($sql);
        $statement->bindParam(':agentUuid', $uuid, PDO::PARAM_STR);

        $agentNationality = '';
        if ($statement->execute()) {
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $agentNationality = $result['nationality'];;
            }
        }
        return $agentNationality;
    }
}
