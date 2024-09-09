<?php

namespace App\Entity;

use App\Tools\Person;

class Target extends Person
{
    protected string $codeName;

    public function getCodeName(): string
    {
        return $this->codeName;
    }
}
