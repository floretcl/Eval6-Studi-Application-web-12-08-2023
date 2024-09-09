<?php

namespace App\Entity;

use stdClass;

class Admin extends stdClass {
    protected string $uuid;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $passwordHash;
    protected string $creationDate;

    public function getUUID (): string {
        return $this->uuid;
    }
    public function getFirstName(): string {
        return $this->firstName;
    }
    public function getLastName(): string {
        return $this->lastName;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPasswordHash(): string {
        return $this->passwordHash;
    }
    public function getCreationDate(): string {
        $timestamp = $this->creationDate;
        return date('Y-m-d H:i', strtotime($timestamp));
    }
}
