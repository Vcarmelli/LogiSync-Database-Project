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

    if(removeInfo($table, $id) == true) {
        echo 'true';
    } else {
        echo 'false';
    }
}

function validInfo($table, $data) {
    switch ($table) {
        case 'addSupplierForm':
        case 'supplier':
            $supplier = new ValidateSupplierForm($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            return $supplier->validateSupplierForm();
        case 'addProductForm':
        case 'product':
            $product = new ValidateProductForm($data['productName'], $data['supplierId'], $data['price']);
            return $product->validateProductForm();
        case 'addOrderForm':
        case 'purchaseorder':
            $order = new ValidateOrderForm($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            return $order->validateOrderForm();
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
        case 'supplier':
            return deleteInfo("supplier", "SupplierID", $id);
        case 'product':
            return deleteInfo("product", "ProductID", $id);
        case 'purchaseorder':
            return deleteInfo("purchaseorder", "OrderID", $id);
        default:
            return false;
    }
}