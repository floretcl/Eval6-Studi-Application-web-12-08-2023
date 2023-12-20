<?php 
class MissionType extends stdClass {
    private string $id;
    private string $name;

    /*
    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
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
