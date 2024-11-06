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
        if($employee_id < 0 || $employee_id >= $this->maxSize || $this->employees[$employee_id] == null) return false;
        
        $this->employees[$employee_id] = null;
        return true;
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
        $count = 0;
        for($i = 0; $i < $this->maxSize; $i++) {
            if($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Commissioned Employee") {
                $count++;
            }
        }

        return $count;
    }

    public function countHE() {
        $count = 0;
        for($i = 0; $i < $this->maxSize; $i++) {
            if($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Hourly Employee") {
                $count++;
            }
        }

        return $count;
    }
    
    public function countPW() {
        $count = 0;
        for($i = 0; $i < $this->maxSize; $i++) {
            if($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Piece Worker") {
                $count++;
            }
        }

        return $count;
    }

    public function display() {
        $allEmployees = [];

        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] !== null) {
                $employee = $this->employees[$i]->getInfos();
                array_push($allEmployees, [
                    $employee["name"],
                    $employee["address"],
                    $employee["age"],
                    $employee["companyName"],
                    $employee["type"],
                    $i
                ]);
            }
        }

        return $allEmployees;
    }

    public function displayCE() {
        $allCEEmployees = [];

        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Commissioned Employee") {
                $employee = $this->employees[$i]->getInfos();
                array_push($allCEEmployees, [
                    $employee["name"],
                    $employee["address"],
                    $employee["age"],
                    $employee["companyName"],
                    $employee["type"]
                ]);
            }
        }

        return $allCEEmployees;
    }

    public function displayHE() {
        $allHEEmployees = [];

        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Hourly Employee") {
                $employee = $this->employees[$i]->getInfos();
                array_push($allHEEmployees, [
                    $employee["name"],
                    $employee["address"],
                    $employee["age"],
                    $employee["companyName"],
                    $employee["type"]
                ]);
            }
        }

        return $allHEEmployees;
    }

    public function displayPW() {
        $allPWEmployees = [];

        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] !== null && $this->employees[$i]->getInfos()["type"] == "Piece Worker") {
                $employee = $this->employees[$i]->getInfos();
                array_push($allPWEmployees, [
                    $employee["name"],
                    $employee["address"],
                    $employee["age"],
                    $employee["companyName"],
                    $employee["type"]
                ]);
            }
        }

        return $allPWEmployees;
    }

    public function payroll() {
        $allEmployees = [];

        for($i = 0; $i < $this->maxSize; $i++) {
            if ($this->employees[$i] !== null) {
                $employee = $this->employees[$i]->getInfos();
                $determinants = $this->employees[$i]->getDeterminants();

                $data = [
                    $i,
                    $employee["name"],
                    $employee["address"],
                    $employee["age"],
                    $employee["companyName"],
                    $employee["type"],
                    $this->employees[$i]->earnings()
                ];

                if($employee["type"] == "Commissioned Employee") {
                    array_push($data, $determinants["regularSalary"]);
                    array_push($data, $determinants["itemSold"]);
                    array_push($data, $determinants["commissionRate"]);
                }

                if($employee["type"] == "Hourly Employee") {
                    array_push($data, $determinants["hoursWorked"]);
                    array_push($data, $determinants["hourlyRate"]);
                }

                if($employee["type"] == "Piece Worker") {
                    array_push($data, $determinants["itemsProduced"]);
                    array_push($data, $determinants["wagePerItem"]);
                }
                
                array_push($allEmployees, $data);
            }
        }

        return $allEmployees;
    }

    public function getSize() {
        return $this->maxSize;
    }
}