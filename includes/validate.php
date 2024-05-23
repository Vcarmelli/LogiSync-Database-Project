<?php

require_once 'validator.php';
class ValidateSupplierForm extends Validator {

    public function __construct($supplierName, $contactPerson, $contactNumber) {
        parent::__construct($supplierName, $contactPerson, $contactNumber, 
                            null, null, null, null, null, null);
    }

    public function validateSupplierForm() {
        $valid = true;
        if ($this->isInvalidSupplierName()) {
            $valid = false;
        }

        if ($this->isInvalidName("contact")) {
            $valid = false;
        }

        if ($this->isInvalidContactNumber()) {
            $valid = false;
        }
        return $valid;
    }
}

class ValidateProductForm extends Validator {

    public function __construct($productName, $supplierId, $price) {
        parent::__construct( null, null, null, $productName, $supplierId, $price, 
                             null, null, null);
    }

    public function ValidateProductForm() {
        $valid = true;
        if ($this->isInvalidName("product")) {
            $valid = false;
        }
        return $valid;
    }
}

class ValidateOrderForm extends Validator {

    public function __construct($supplierIdPO, $orderDate, $deliveryDate) {
        parent::__construct( null, null, null, null, null, null,
                             $supplierIdPO, $orderDate, $deliveryDate);
    }

    public function validateOrderForm() {
        $valid = true;
        if ($this->isInvalidDate()) {
            $valid = false;
        }
        return $valid;
    }
}