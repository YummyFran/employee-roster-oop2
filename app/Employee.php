<?php

abstract class Employee extends Person {
    private $companyName;

    public function __construct($companyName) {
        $this->companyName = $companyName;
    }

    abstract public function earnings();
}