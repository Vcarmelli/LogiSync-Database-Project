<?php

require_once 'validator.php';
class ValidateSupplierForm extends Validator {
    public $errors = [];

    public function __construct($supplierName, $contactPerson, $contactNumber) {
        parent::__construct($supplierName, $contactPerson, $contactNumber, 
                            null, null, null, null, null, null);
    }

    public function validateSupplierForm() {

        if ($this->isInvalidSupplierName()) {
            $this->errors['supplierName'] = "Invalid supplier name format.";
        }

        if ($this->isInvalidName("contact")) {
            $this->errors['contactPerson'] = "Invalid name format.";
        }

        if ($this->isInvalidContactNumber()) {
            $this->errors['contactNumber'] = "Invalid contact number.";
        }
    }
}

class ValidateProductForm extends Validator {
    public $errors = [];

    public function __construct($productName, $supplierId, $price) {
        parent::__construct( null, null, null, $productName, $supplierId, $price, 
                             null, null, null);
    }

    public function ValidateProductForm() {

        if ($this->isInvalidName("product")) {
            $this->errors['productName'] = "Invalid name format.";
        }
    }
}

class ValidateOrderForm extends Validator {
    public $errors = [];

    public function __construct($supplierIdPO, $orderDate, $deliveryDate) {
        parent::__construct( null, null, null, null, null, null,
                             $supplierIdPO, $orderDate, $deliveryDate);
    }

    public function validateOrderForm() {

        if ($this->isInvalidDate()) {
            $this->errors['deliveryDate'] = "Invalid date.";
        }
    }
}