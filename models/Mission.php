<?php

class Mission extends stdClass {
    private string $uuid;
    private string $codeName;
    private string $title;
    private string $description;
    private string $country;
    private string $type;
    private string $specialty;
    private string $status;
    private string $startDate;
    private string $endDate;

    /*
    public function __construct(
        string $uuid, 
        string $codeName,
        string $title,
        string $description,
        string $country,
        string $type,
        string $specialty,
        string $status,
        ?string $startDate = null,
        ?string $endDate = null
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->title = $title;
        $this->description = $description;
        $this->country = $country;
        $this->type = $type;
        $this->specialty = $specialty;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    */

    public function getUUID(): string {
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
    public function getDescriptionShort(): string {
        $desc = $this->description;
        $shortDesc = substr($desc, 0, 18);
        return $shortDesc . '...';
    }
    public function getCountry(): string {
        return $this->country;
    }
    public function getType(): string {
        return $this->type;
    }
    public function getSpecialty(): string {
        return $this->specialty;
    }
    public function getStatus(): string {
        return $this->status;
    }
    public function getStartDate(): string {
        $datetime = $this->startDate;
        return date('Y-m-d H:i', strtotime($datetime));
    }
    public function getStartDateLong(): string {
        $datetime = $this->startDate;
        $date = date('l, j M Y', strtotime($datetime));
        $hour = date('h:i a', strtotime($datetime));
        return $date.' at '.$hour;
    }
    public function getEndDate(): string {
        $datetime = $this->endDate;
        return date('Y-m-d H:i', strtotime($datetime));
    }
    public function getEndDateLong(): string {
        $datetime = $this->endDate;
        $date = date('l, j M Y', strtotime($datetime));
        $hour = date('h:i a', strtotime($datetime));
        return $date.' at '.$hour;
    }
}
