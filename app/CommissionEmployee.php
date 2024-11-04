<?php

class CommissionEmployee extends Employee {
    private $regularSalary;
    private $itemSold;
    private $commissionRate;

    public function __construct($regularSalary,  $itemSold, $commissionRate) {
        $this->regularySalary = $regularSalary;
        $this->itemSold = $itemSold;
        $this->commissionRate = $commissionRate;
    }
}