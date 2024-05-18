<?php

include 'database.php';
include 'validate.php';

if(isset($_POST["addSupplier"])) {
    
    $supplierName = $_POST["supplierName"];
    $contactPerson = $_POST["contactPerson"];
    $contactNumber = $_POST["contactNumber"];
    

    $supplier = new ValidateSupplierForm($supplierName, $contactPerson, $contactNumber);

    $supplier->validateSupplierForm();

    echo "SUBMIT.PHP EXECUTED supplier !!  ";

} else if(isset($_POST["addProduct"])) {
    
    $productName = $_POST["productName"];
    $supplierId = $_POST["supplierId"];
    $price = $_POST["price"];

    $product = new ValidateProductForm($productName, $supplierId, $price);

    $product->validateProductForm();

    echo "SUBMIT.PHP EXECUTED product!! ";

} else if(isset($_POST["addOrder"])) {
    
    $supplierIdPO = $_POST["supplierIdPO"];
    $orderDate = $_POST["orderDate"];
    $deliveryDate = $_POST["deliveryDate"];
    
    $order = new ValidateOrderForm($supplierIdPO, $orderDate, $deliveryDate);

    $order->validateOrderForm();

    echo "SUBMIT.PHP EXECUTED ORDER !!  ";

}



function saveSupplier($supplierName, $contactPerson, $contactNumber) {
    try {

        
        $database = new Database();
        $stmt = $database->connect()->prepare("INSERT INTO supplier (SupplierID, SupplierName, ContactPerson, ContactNumber) VALUES (?, ?, ?, ?)");

    }
}

function getNewSupplierID() {
    // Generate a random 4-digit number
    $randomNumber = mt_rand(1000, 9999);

    // Query the database to retrieve all existing supplier IDs
    // Assuming you have a database connection established
    $existingSupplierIds = []; // Initialize an array to store existing supplier IDs

    $database = new Database();
    $stmt = $database->connect()->prepare("SELECT SupplierID FROM supplier;");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingSupplierIds[] = $row['SupplierID'];
    }

    // Check if the random number already exists in the list of supplier IDs
    while (in_array($randomNumber, $existingSupplierIds)) {
    // If the random number exists, generate a new random number
    $randomNumber = mt_rand(1000, 9999);
    }

    // Now $randomNumber is a unique 4-digit number not present in the database
    // You can use this as the new supplier ID when adding a new supplier
    return $randomNumber;

}