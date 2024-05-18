<?php

require_once 'validator.php';
class ValidateSupplierForm extends Validator {

    public function __construct($supplierName, $contactPerson, $contactNumber) {
        parent::__construct($supplierName, $contactPerson, $contactNumber, 
                            null, null, null, null, null, null);
    }

    public function validateSupplierForm() {
        if ($this->isInvalidName("supplier")) {
            echo "INVALID SUP NAME ";
        }

        if ($this->isInvalidName("contact")) {
            echo "INVALID CONTACT NAME ";
        }

        if ($this->isInvalidContactNumber()) {
            echo "INVALID NUMBER ";
        }
    }
}

class ValidateProductForm extends Validator {

    public function __construct($productName, $supplierId, $price) {
        parent::__construct( null, null, null, $productName, $supplierId, $price, 
                             null, null, null);
        $this->price = $price;
    }

    public function ValidateProductForm() {
        if ($this->isInvalidName("product")) {
            echo "INVALID PRODUCT NAME ";
        }
        echo $this->price;
    }
}

class ValidateOrderForm extends Validator {

    public function __construct($supplierIdPO, $orderDate, $deliveryDate) {
        parent::__construct( null, null, null, null, null, null,
                             $supplierIdPO, $orderDate, $deliveryDate);

        $this->deliveryDate = $deliveryDate;
    }

    public function validateOrderForm() {
        if ($this->isInvalidDate()) {
            echo "INVALID  ORDER DATE ";
        }
        echo $this->deliveryDate;
    }
}