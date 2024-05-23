<?php

include_once 'database.php';
include_once 'validate.php';
include_once 'crud.php';

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    
    $table = $_POST['table'];
    $data = $_POST['data'];

    if (validInfo($table, $data) == true)  {
        addInfo($table, $data);
        echo 'true';
    } else {
        echo 'false';
    }

} else if(isset($_POST['action']) && $_POST['action'] == 'edit') {
    
    $table = $_POST['table'];
    $id = $_POST['id'];
    $data = json_decode($_POST['data'], true);

    if (validInfo($table, $data) == true)  {
        saveInfo($table, $id, $data);
        echo 'true';
    } else {
        echo 'false';
    }

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
        case 'supplier':
            $supplier = new ValidateSupplierForm($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            $valid = $supplier->validateSupplierForm();
            return $valid;
        case 'addProductForm':
        case 'product':
            $product = new ValidateProductForm($data['productName'], $data['supplierId'], $data['price']);
            $valid = $product->validateProductForm();
            return $valid;
        case 'addOrderForm':
        case 'purchaseorder':
            $order = new ValidateOrderForm($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            $valid = $order->validateOrderForm();
            return $valid;
        default:
            return false;
    }
}

function addInfo($table, $data) {
    switch ($table) {
        case 'addSupplierForm':
            saveSupplier($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            break;
        case 'addProductForm':
            saveProduct($data['productName'], $data['supplierId'], $data['price']);
            break;
        case 'addOrderForm':
            saveOrder($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            break;
        default:
            break;
    }
}

function saveInfo($table, $id, $data) {
    switch ($table) {
        case 'supplier':
            modifySupplier($id, $data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            break;
        case 'product':
            modifyProduct($id, $data['productName'], $data['supplierId'], $data['price']);
            break;
        case 'purchaseorder':
            modifyOrder($id, $data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            break;
        default:
            break;
    }
}

function removeInfo($table, $id) {
    switch ($table) {
        case 'supplierTable':
            deleteInfo("supplier", "SupplierID", $id);
            break;
        case 'productTable':
            deleteInfo("product", "ProductID", $id);
            break;
        case 'orderTable':
            deleteInfo("purchaseorder", "OrderID", $id);
            break;
        default:
            break;
    }
}