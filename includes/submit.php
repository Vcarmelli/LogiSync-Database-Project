<?php

include_once 'database.php';
include_once 'validate.php';
include_once 'crud.php';

header('Content-Type: application/json');
$response = [];

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    
    $table = $_POST['table'];
    $data = $_POST['data'];
    $errors = validInfo($table, $data);

    if (empty($errors))  {
        addInfo($table, $data);
        $response = ['success' => true, 'message' => 'Added successfully.'];
    } else {    
        $response = ['success' => false, 'errors' => $errors];
    }

    echo json_encode($response);

} else if(isset($_POST['action']) && $_POST['action'] == 'edit') {
    
    $table = $_POST['table'];
    $id = $_POST['id'];
    $data = json_decode($_POST['data'], true);
    $errors = validInfo($table, $data);

    if (empty($errors))  {
        saveInfo($table, $id, $data);
        $response = ['success' => true, 'message' => 'Updated successfully.'];
    } else {
        $response = ['success' => false, 'errors' => $errors];
    }
    echo json_encode($response);

} else if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    
    $table = $_POST['table'];
    $id = $_POST['id'];

    if(removeInfo($table, $id) == true) {
        $response = ['success' => true, 'message' => 'Deleted successfully.'];
    } else {
        $response = ['success' => false, 'errors' => 'Cannot be deleted.'];
    }
    echo json_encode($response);
}

function validInfo($table, $data) {
    switch ($table) {
        case 'addSupplierForm':
        case 'supplier':
            $supplier = new ValidateSupplierForm($data['supplierName'], $data['contactPerson'], $data['contactNumber']);
            $supplier->validateSupplierForm();
            return $supplier->errors;
        case 'addProductForm':
        case 'product':
            $product = new ValidateProductForm($data['productName'], $data['supplierId'], $data['price']);
            $product->validateProductForm();
            return $product->errors;
        case 'addOrderForm':
        case 'purchaseorder':
            $order = new ValidateOrderForm($data['supplierIdPO'], $data['orderDate'], $data['deliveryDate']);
            $order->validateOrderForm();
            return $order->errors;
        default:
            return [];
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

