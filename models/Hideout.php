<?php
class Hideout {
    private string $uuid;
    private string $codeName;
    private string $address;
    private string $country;
    private string $hideoutType;

    /*
    public function __construct(
        string $uuid,
        string $codeName,
        string $address,
        string $country,
        string $hideoutType
        ) {
        $this->uuid = $uuid;
        $this->codeName = $codeName;
        $this->address = $address;
        $this->country = $country;
        $this->hideoutType = $hideoutType;
    }
    */

    public function getUUID(): string {
        return $this->uuid;
    }
    public function getCodeName(): string {
        return $this->codeName;
    }
    public function getAddress(): string {
        return $this->address;
    }
    public function getAddressArray(): array {
        $address = $this->address;
        return explode(',', $address);
    }
    public function getCountry(): string {
        return $this->country;
    }
    public function getType(): string {
        return $this->hideoutType;
    }
}
