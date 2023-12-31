<?php
class Admin extends stdClass {
    private string $uuid;
    private ?string $firstName;
    private ?string $lastName;
    private string $email;
    private string $passwordHash;
    private string $creationDate;

    /*
    public function __construct(
        string $uuid,
        string $firstName,
        string $lastName,
        string $email,
        string $passwordHash,
        string $creationDate,
        ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->creationDate = $creationDate;
    }
    */

    public function getUUID (): string {
        return $this->uuid;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
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
        $date = date('Y-m-d H:i', strtotime($timestamp));
        return $date;
    }
}
