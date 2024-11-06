<?php

abstract class Employee extends Person {
    private $companyName;
    protected $type;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    abstract public function earnings();

    public function getInfos() {
        return array(
            "name" => $this->name, 
            "address" => $this->address,
            "age" => $this->age,
            "companyName" => $this->companyName,
            "type" => $this->type
        );
    }
}