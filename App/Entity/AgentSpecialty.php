<?php

namespace App\Entity;

class AgentSpecialty
{
    protected string $agentUUID;
    protected string $specialtyId;

    public function getAgentUUID(): string
    {
        return $this->agentUUID;
    }

    public function getSpecialtyId(): int
    {
        return $this->specialtyId;
    }
}
