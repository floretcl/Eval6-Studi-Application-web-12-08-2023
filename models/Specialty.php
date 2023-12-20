<?php

class Specialty extends stdClass {
    private string $id;
    private string $name;

    /*
    public function __construct(string $name) {
        $this->name = $name;
    }
    */

    public function getId(): string {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
}
