<?php

require_once 'validator.php';
class ValidateSupplierForm extends Validator {
    public $errors = [];

    public function __construct($supplierName, $contactPerson, $contactNumber) {
        parent::__construct($supplierName, $contactPerson, $contactNumber, 
                             null, null, null, null, null, null, null);
    }

    public function validateSupplierForm($operation) {

        if ($this->isInvalidSupplierName()) {
            $this->errors['supplierName'] = "Invalid supplier name format.";
        }

        if ($this->isInvalidName("contact")) {
            $this->errors['contactPerson'] = "Invalid name format.";
        }

        if ($this->isInvalidContactNumber()) {
            $this->errors['contactNumber'] = "Invalid contact number.";
        }
        if ($operation == 'add') {
            if ($this->supplierExists()) {
                $this->errors['supplierName'] = "This supplier already exists.";
            }
        }
        
    }
}

class ValidateProductForm extends Validator {
    public $errors = [];

    public function __construct($productName, $supplierId, $price, $quantity) {
        parent::__construct( null, null, null, $productName, $supplierId, $price, $quantity,
                             null, null, null);
    }

    public function ValidateProductForm($operation) {

        if ($this->isInvalidName("product")) {
            $this->errors['productName'] = "Invalid name format.";
        }

        if ($this->isInvalidPrice()) {
            $this->errors['price'] = "Price must be between 0 and 10000.";
        }

        if ($this->isInvalidQuantity()) {
            $this->errors['quantity'] = "Quantity must be between 0 and 1000.";
        }
        if ($operation == 'add') {
            if ($this->productExists()) {
                $this->errors['productName'] = "This product already exists.";
            }
        }
    }
}

class ValidateOrderForm extends Validator {
    public $errors = [];

    public function __construct($supplierIdPO, $orderDate, $deliveryDate, $quantities) {
        parent::__construct( null, null, null, null, null, null, $quantities,
                             $supplierIdPO, $orderDate, $deliveryDate);
    }

    public function validateOrderForm() {

        if ($this->isInvalidDate()) {
            $this->errors['deliveryDate'] = "Invalid date.";
        }
        foreach ($this->quantity as $prods) {
            if ($this->isInvalidQuantity($prods['quantity'])) {
                $this->errors['quantity'] = "Quantity must be between 0 and 1000.";
            }
        }
    }
}