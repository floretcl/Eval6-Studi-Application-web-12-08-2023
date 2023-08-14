<?php

class Mission {
    private string $uuid;
    private string $codeName;
    private string $title;
    private string $description;
    private string $country;
    private int $typeUuid;
    private string $specialty;
    private int $statusUuid;
    private string $startDate;
    private string $endDate;

    public function __construct(
        string $uuid, 
        string $codeName,
        string $title,
        string $description,
        string $country,
        int $typeUuid,
        string $specialty,
        int $statusUuid,
        ?string $startDate = null,
        ?string $endDate = null
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->title = $title;
        $this->description = $description;
        $this->country = $country;
        $this->typeUuid = $typeUuid;
        $this->specialty = $specialty;
        $this->statusUuid = $statusUuid;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getCodeName(): string {
        return $this->codeName;
    }
    public function getTitle(): string {
        return $this->title;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function getCountry(): string {
        return $this->country;
    }
    public function getTypeUuid(): int {
        return $this->typeUuid;
    }
    public function getSpecialty(): string {
        return $this->specialty;
    }
    public function getstatus(): int {
        return $this->statusUuid;
    }
    public function getStarDate(): string {
        $timestamp = $this->startDate;
        $date = date('Y-m-d H:i:s', $timestamp);
        return $date;
    }
    public function getEndDate(): string {
        $timestamp = $this->endDate;
        $date = date('Y-m-d H:i:s', $timestamp);
        return $date;
    }
}
