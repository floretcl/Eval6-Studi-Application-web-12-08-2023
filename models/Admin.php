<?php
class Admin {
    private string $uuid;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $creationDate;

    /*
    public function __construct(
        string $uuid,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $creationDate,
        ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->creationDate = $creationDate;
    }
    */

    public function getUuid (): string {
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
    public function getPassword(): string {
        return $this->password;
    }
    public function getCreationDate(): string {
        $timestamp = $this->creationDate;
        $date = date('Y-m-d H:i', strtotime($timestamp));
        return $date;
    }
}