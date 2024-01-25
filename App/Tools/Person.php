<?php

namespace App\Tools;

use stdClass;

class Person extends stdClass
{
    protected string $uuid;
    protected ?string $firstName;
    protected ?string $lastName;
    protected string $birthday;
    protected string $nationality;

    public function getUUID(): string
    {
        return $this->uuid;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getBirthday(): string
    {
        $datetime = $this->birthday;
        return date('Y-m-d', strtotime($datetime));
    }

    public function getAge(): int
    {
        $birth = $this->getBirthday();
        $diff = date_diff(date_create($birth), date_create());
        $age = $diff->format('%Y');
        return (int)$age;
    }

    public function getNationality(): string
    {
        return $this->nationality;
    }
}
