<?php

namespace App\Entity;

use App\Tools\Person;

class Agent extends Person
{
    protected string $code;
    protected ?string $mission;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }
}
