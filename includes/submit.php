<?php

include_once 'database.php';
include_once 'validate.php';
include_once 'crud.php';

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    
    $table = $_POST['table'];
    $data = $_POST['data'];
    $save = validInfo($table, $data);
    echo $save;
    if ($save == true) {
        saveInfo($table, $data);
        echo "save run";
    }


} else if(isset($_POST['action']) && $_POST['action'] == 'edit') {
    
    $table = $_POST['table'];
    $id = $_POST['id'];
    $data = $_POST['data'];
    echo "EDIT HERE";
    echo $table;
    echo $id;
    //echo $data;

} else if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    
    $table = $_POST['table'];
    $id = $_POST['id'];
    echo "DELETEE HERE";
    echo $table;
    echo $id;
}

function validInfo($table, $data) {
    switch ($table) {
        case 'addSupplierForm':
            $supplier = new ValidateSupplierForm($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            $supplier->validateSupplierForm();
            break;
        case 'addProductForm':
            $product = new ValidateProductForm($data['productName'], $data['supplierId'], $data['price']);
            $product->validateProductForm();
            break;
        case 'addOrderForm':
            $order = new ValidateOrderForm($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            $order->validateOrderForm();
            break;
        default:
          //code block
      }
    return true;
}

function saveInfo($table, $data) {
    switch ($table) {
        case 'addSupplierForm':
            saveSupplier($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            echo "SUBMIT.PHP EXECUTED supplier !!  ";
            break;
        case 'addProductForm':
            saveProduct($data['productName'], $data['supplierId'], $data['price']);
            echo "SUBMIT.PHP EXECUTED product!! ";
            break;
        case 'addOrderForm':
            saveOrder($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            echo "SUBMIT.PHP EXECUTED ORDER !!  ";
            break;
        default:
          //code block
      }
    
}