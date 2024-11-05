<?php

class EmployeeRoster {
    private $roster = [];
    private $maxSize;

    public function __construct($maxSize) {
        $this->maxSize = $maxSize;
        array_fill(0, $maxSize, null);
    }

    public function add(Employee $employee) {

    }

    public function remove($employee_id) {

    }

    public function count() {

    }

    public function countCE() {

    }

    public function countHE() {

    }
    
    public function countPE() {

    }

    public function payroll() {

    }

    public function getSize() {
        return $this->maxSize;
    }
}