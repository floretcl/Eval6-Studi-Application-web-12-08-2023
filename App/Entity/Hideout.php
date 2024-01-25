<?php

namespace App\Entity;

use stdClass;

class Hideout extends stdClass {
    protected string $uuid;
    protected string $codeName;
    protected string $address;
    protected string $country;
    protected string $hideoutType;

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
