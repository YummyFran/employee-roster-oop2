<?php

class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $hourlyRate;

    public function __construct($hoursWorked, $hourlyRate, $name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->hourlyRate = $hourlyRate;
        $this->type = "Hourly Employee";
    }

    public function earnings() {
        return $this->hoursWorked > 40 ? $this->hoursWorked * ($this->hourlyRate * 1.5) : $this->hoursWorked * $this->hourlyRate;
    }
}