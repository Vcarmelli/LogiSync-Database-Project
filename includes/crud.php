<?php


function saveSupplier($supplierName, $contactPerson, $contactNumber) {
    try {
        $dbase = new Database();
        $supplierID = getNewSupplierID($dbase);

        $stmt = $dbase->connect()->prepare("INSERT INTO supplier (SupplierID, SupplierName, ContactPerson, ContactNumber) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute(array($supplierID, $supplierName, $contactPerson, $contactNumber))) {
            $stmt = null;
            header("location: ../pages/forms.php?error=inSaveSupplier");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in saveSupplier:" . $e->getMessage());
    }

}

function getNewSupplierID($db) {
    // Generate a random 4-digit number
    $randomNumber = mt_rand(1000, 9999);
    $existingSupplierIds = [];

    $stmt = $db->connect()->prepare("SELECT SupplierID FROM supplier;");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingSupplierIds[] = $row['SupplierID'];
    }

    // Check if the random number already exists in the list of supplier IDs
    while (in_array($randomNumber, $existingSupplierIds)) {
        $randomNumber = mt_rand(1000, 9999);
    }

    print($randomNumber);
    return $randomNumber;
}

function saveProduct($productName, $supplierId, $price) {
    try {
        $dbase = new Database();
        // Generate a random letter from A to Z
        $randomLetter1 = chr(mt_rand(65, 90)); // ASCII values for A-Z
        $randomLetter2 = chr(mt_rand(65, 90)); // ASCII values for A-Z

        // Generate a random number between 10000 and 99999
        $randomNumber = mt_rand(10000, 99999);

        // Combine the random letter with the random number
        $randomId = $randomLetter1 . $randomLetter2 . "-" . $randomNumber;
        print($randomId);

        $stmt = $dbase->connect()->prepare("INSERT INTO product (ProductID, ProductName, SupplierID, Price) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute(array($randomId, $productName, $supplierId, $price))) {
            $stmt = null;
            header("location: ../pages/forms.php?error=inSaveProduct");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in saveProduct:" . $e->getMessage());
    }

}

function saveOrder($supplierIdPO, $orderDate, $deliveryDate) {
    try {
        $dbase = new Database();
        $randomValue = uniqid(mt_rand(), true); // Generating a random unique identifier

        // Hash the random value using MD5
        $hashedValue = md5($randomValue);

        // Truncate the hashed value to the desired length (e.g., 8 characters)
        $randomString = substr($hashedValue, 0, 8);

        // Convert the truncated random string to uppercase
        $randomString = strtoupper($randomString);

        print($randomString);

        $stmt = $dbase->connect()->prepare("INSERT INTO purchaseorder (OrderID, SupplierID, OrderDate, DeliveryDate) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute(array($randomString, $supplierIdPO, $orderDate, $deliveryDate))) {
            $stmt = null;
            header("location: ../pages/forms.php?error=inSaveOrder");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in saveOrdert:" . $e->getMessage());
    }

}