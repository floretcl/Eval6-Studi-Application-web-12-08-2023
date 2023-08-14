<?php

class Agent {
    private string $uuid;
    private string $code;
    private string $firstName;
    private string $lastName;
    private int $birthday;
    private string $nationality;
    private string $missionUuid;

    public function __construct(
        string $uuid,
        string $code,
        string $firstName,
        string $lastName,
        int $birthday,
        string $nationality,
        string $missionUuid
        ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->nationality =$nationality;
        $this->missionUuid = $missionUuid;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getCode(): string {
        return $this->code;
    }
    public function getFirstName(): string {
        return $this->firstName;
    }
    public function getLastName(): string {
        return $this->lastName;
    }
    public function getBirthday(): string {
        $timestamp = $this->birthday;
        $date = date('Y-m-d', $timestamp);
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
    public function getMissionUuid(): string {
        return $this->missionUuid;
    }
}