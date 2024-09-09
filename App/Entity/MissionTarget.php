<?php

namespace App\Entity;

class MissionTarget
{
    protected string $missionUUID;
    protected string $targetUUID;

    public function getMissionUUID(): string
    {
        return $this->missionUUID;
    }

    public function getTargetUUID(): int
    {
        return $this->targetUUID;
    }
}
