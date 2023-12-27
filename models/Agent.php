<?php

class Agent extends stdClass {
    private string $uuid;
    private string $code;
    private ?string $firstName;
    private ?string $lastName;
    private string $birthday;
    private string $nationality;
    private ?string $mission;

    /*
    public function __construct(
        string $uuid,
        string $code,
        string $firstName,
        string $lastName,
        string $birthday,
        string $nationality
        ) {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->nationality =$nationality;
    }
    */

    public function getUUID(): string {
        return $this->uuid;
    }
    public function getCode(): string {
        return $this->code;
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
    public function getMission(): ?string {
        return $this->mission;
    }
}
