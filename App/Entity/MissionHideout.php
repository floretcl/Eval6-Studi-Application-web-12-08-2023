<?php

namespace App\Entity;

class MissionHideout
{
    protected string $missionUUID;
    protected string $hideoutUUID;

    public function getMissionUUID(): string
    {
        return $this->missionUUID;
    }

    public function getHideoutUUID(): int
    {
        return $this->hideoutUUID;
    }
}
