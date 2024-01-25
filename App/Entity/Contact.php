<?php

namespace App\Entity;

use App\Tools\Person;

class Contact extends Person
{
    protected string $codeName;

    public function getCodeName(): string
    {
        return $this->codeName;
    }
}
