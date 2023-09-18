<?php

class Agent {
    private string $uuid;
    private string $code;
    private ?string $firstName;
    private ?string $lastName;
    private string $birthday;
    private string $nationality;
    private ?string $missionUUID;
    private string $specialty;

    /*
    public function __construct(
        string $uuid,
        string $code,
        string $firstName,
        string $lastName,
        string $birthday,
        string $nationality,
        string $missionUUID
        ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->nationality =$nationality;
        $this->missionUUID = $missionUUID;
    }
    */

    public function getUUID(): string {
        return $this->uuid;
    }
    public function getCode(): string {
        return $this->code;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getBirthday(): string {
        $datetime = $this->birthday;
        $date = date('Y-m-d', strtotime($datetime));
        return $date;
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
    public function getMissionUUID() {
        return $this->missionUUID;
    }
    public function getSpecialty(): string {
        return $this->specialty;
    }
}
