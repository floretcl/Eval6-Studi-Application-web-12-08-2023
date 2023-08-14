<?php
class Hideout {
    private string $uuid;
    private string $codeName;
    private string $adress;
    private string $country;
    private int $type;

    public function __construct(
        string $uuid,
        string $codeName,
        string $adress,
        string $country,
        int $type
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->adress = $adress;
        $this->country = $country;
        $this->type = $type;
    }

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getCodeName(): string {
        return $this->codeName;
    }
    public function getAdress(): string {
        return $this->adress;
    }
    public function getCountry(): string {
        return $this->country;
    }
    public function getType(): string {
        return $this->type;
    }
}
