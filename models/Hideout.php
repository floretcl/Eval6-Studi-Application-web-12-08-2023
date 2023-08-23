<?php
class Hideout {
    private string $uuid;
    private string $codeName;
    private string $adress;
    private string $country;
    private string $hideoutType;

    /*
    public function __construct(
        string $uuid,
        string $codeName,
        string $adress,
        string $country,
        string $hideoutType
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->adress = $adress;
        $this->country = $country;
        $this->hideoutType = $hideoutType;
    }
    */

    public function getUuid(): string {
        return $this->uuid;
    }
    public function getCodeName(): string {
        return $this->codeName;
    }
    public function getAdress(): string {
        return $this->adress;
    }
    public function getAdressArray(): array {
        $adress = $this->adress;
        $array = explode(',', $adress);
        return $array;
    }
    public function getCountry(): string {
        return $this->country;
    }
    public function getType(): string {
        return $this->hideoutType;
    }
}
