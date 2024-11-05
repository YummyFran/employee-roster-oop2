<?php

class CommissionEmployee extends Employee {
    private $regularSalary;
    private $itemSold;
    private $commissionRate;

    public function __construct($regularSalary, $itemSold, $commissionRate, $name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemSold = $itemSold;
        $this->commissionRate = $commissionRate;

    }

    public function earnings() {
        return $regularSalary + ($itemSold * $commissionRate);
    }

    public function getName() {
        return $this->name;
    }
}