<?php
class Admin {
    private string $uuid;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private int $creationDate;

    public function __construct(
        string $uuid,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $creationDate,
        ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->creationDate = $creationDate;
    }

    public function getUuid () {
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
    public function getPasssword(): string {
        return $this->lastName;
    }
    public function getCreationDate(): string {
        $timestamp = $this->creationDate;
        $date = date('Y-m-d', $timestamp);
        return $date;
    }
}