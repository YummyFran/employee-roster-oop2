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
        $this->type = "Commissioned Employee";
    }

    public function getDeterminants() {
        return array(
            "regularSalary" => $this->regularSalary,
            "itemSold" => $this->itemSold,
            "commissionRate" => $this->commissionRate
        );
    }

    public function earnings() {
        return $this->regularSalary + ($this->itemSold * $this->commissionRate);
    }
}