<?php

namespace App\Entity;

class MissionContact
{
    protected string $missionUUID;
    protected string $contactUUID;

    public function getMissionUUID(): string
    {
        return $this->missionUUID;
    }

    public function getContactUUID(): int
    {
        return $this->contactUUID;
    }
}
