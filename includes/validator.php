<?php

class Validator {
    private $supplierName = null;
    private $contactPerson = null;
    private $contactNumber = null;
    private $productName = null;
    private $supplierId = null;
    private $price = null;
    private $supplierIdPO = null;
    private $orderDate = null;
    private $deliveryDate = null;

    public function __construct($supplierName, $contactPerson, $contactNumber, 
                                $productName, $supplierId, $price, 
                                $supplierIdPO, $orderDate, $deliveryDate) {
        $this->supplierName = $supplierName;
        $this->contactPerson = $contactPerson;
        $this->contactNumber = $contactNumber;
        $this->productName = $productName;
        $this->supplierId = $supplierId;
        $this->price = $price;
        $this->supplierIdPO = $supplierIdPO;
        $this->orderDate = $orderDate;
        $this->deliveryDate = $deliveryDate;
    }

    // Add validation methods here


    protected function isInvalidContactNumber() {
        if (preg_match('/^9[0-9]{9}$/', $this->contactNumber)) {
            return false; // valid number
        }

        return true; // invalid number
    }
    protected function isInvalidName($whichName) {
        $name = "";
        if ($whichName == "supplier") {
            $name = $this->supplierName;
        } else if ($whichName == "product") {
            $name = $this->productName;
        } else if ($whichName == "contact") {
            $name = $this->contactPerson;
        }

        if (preg_match('/^[a-zA-Z ]+$/', $name)) {
            return false; // valid name
        }
        return true; // invalid name
    }

    protected function isInvalidSupplierName() {
        if (preg_match('/^[a-zA-Z \',.-]+$/', $this->supplierName)) {
            return false; // valid name
        }
        return true; // invalid name
    }

    protected function isInvalidDate() {
        $orderDate = strtotime($this->orderDate);
        $deliveryDate = strtotime($this->deliveryDate);

        if ($orderDate <= $deliveryDate) {
            return false; // valid date
        }
        return true;   // invalid date
    }
}

