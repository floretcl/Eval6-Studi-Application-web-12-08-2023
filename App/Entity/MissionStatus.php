<?php

namespace App\Entity;

use stdClass;

class MissionStatus extends stdClass
{
    protected string $id;
    protected string $name;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
