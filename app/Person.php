<?php

class Person {
    protected $name;
    protected $address;
    protected $age;

    public function __construct($name, $address, $age) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
    }
}