<?php

class PieceWorker extends Employee {
    private $itemsProduced;
    private $wagePerItem;

    public function __construct($itemsProduced, $wagePerItem, $name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age, $companyName);
        $this->itemsProduced = $itemsProduced;
        $this->wagePerItem = $wagePerItem;
        $this->type = "Piece Worker";
    }

    public function earnings() {
        return $this->itemsProduced * $this->wagePerItem;
    }
}