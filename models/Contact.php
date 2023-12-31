<?php

class Contact extends stdClass {
    private string $uuid;
    private string $codeName;
    private ?string $firstName;
    private ?string $lastName;
    private string $birthday;
    private string $nationality;

    /*
    public function __construct(
        string $uuid,
        string $codeName,
        string $firstName,
        string $lastName,
        string $birthday,
        string $nationality
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->nationality =$nationality;
    }
    */

    public function getUUID(): string {
        return $this->uuid;
    }
    public function getCodeName(): string {
        return $this->codeName;
    }
    public function getFirstName(): ?string {
        return $this->firstName;
    }
    public function getLastName(): ?string {
        return $this->lastName;
    }
    public function getBirthday(): string {
        $datetime = $this->birthday;
        return date('Y-m-d', strtotime($datetime));
    }
    public function getAge(): int {
        $birth = $this->getBirthday();
        $diff = date_diff(date_create($birth),date_create());
        $age = $diff->format('%Y');
        return (int) $age;
    }
    public function getNationality(): string {
        return $this->nationality;
    }
}
