<?php

class Person {
    private $name;
    private $address;
    private $age;

    public function __construct($name, $address, $age) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
    }
}