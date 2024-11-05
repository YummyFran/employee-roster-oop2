<?php

class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $hourlyRate;

    public function __construct($hoursWorked, $hourlyRate) {
        $this->hoursWorked = $hoursWorked;
        $this->hourlyRate = $hourlyRate;
    }

    public function earnings() {
        return $this->hoursWorked > 40 ? $this->hoursWorked * ($this->hourlyRate * 1.5) : $this->hoursWorked * $this->hourlyRate;
    }
}