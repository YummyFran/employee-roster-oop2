<?php

abstract class Employee extends Person {
    private $companyName;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    abstract public function earnings();
}