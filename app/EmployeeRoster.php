<?php

class EmployeeRoster {
    private $employees = [];
    private $maxSize;

    public function __construct($maxSize) {
        $this->maxSize = $maxSize;
        $this->employees = array_fill(0, $maxSize, null);
    }

    public function add(Employee $employee) {
        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] === null) {
                $this->employees[$i] = $employee;
                return true;
            }
        }

        return false;
    }

    public function remove($employee_id) {

    }

    public function count() {
        $count = 0;
        for($i = 0; $i < $this->maxSize; $i++) {
            if($this->employees[$i] !== null) {
                $count++;
            }
        }

        return $count;
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