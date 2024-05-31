<?php

function saveSupplier($supplierName, $contactPerson, $contactNumber) {
    try {
        $dbase = new Database();
        $newId = getNewSupplierID($dbase);
        $formattedContactNumber = formatContactNumber($contactNumber);

        $stmt = $dbase->connect()->prepare("INSERT INTO supplier (SupplierID, SupplierName, ContactPerson, ContactNumber) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute(array($newId, $supplierName, $contactPerson, $formattedContactNumber))) {
            $stmt = null;
            //header("location: ../pages/forms.php?error=inSaveSupplier");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in saveSupplier:" . $e->getMessage());
    }

}

function saveProduct($productName, $supplierId, $price) {
    try {
        $dbase = new Database();
        
        $newId = getNewProductID($dbase);

        $stmt = $dbase->connect()->prepare("INSERT INTO product (ProductID, ProductName, SupplierID, Price) VALUES (?, ?, ?, ?)");
    
        if(!$stmt->execute(array($newId, $productName, $supplierId, $price))) {
            $stmt = null;
            //header("location: ../pages/forms.php?error=inSaveProduct");
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
        $newId = getNewOrderID($dbase);

        $formattedOrderDate = formatDate($orderDate);
        $formattedDeliveryDate = formatDate($deliveryDate);

        $stmt = $dbase->connect()->prepare("INSERT INTO purchaseorder (OrderID, SupplierID, OrderDate, DeliveryDate) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute(array($newId, $supplierIdPO, $formattedOrderDate, $formattedDeliveryDate))) {
            $stmt = null;
            //header("location: ../pages/forms.php?error=inSaveOrder");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in saveOrder:" . $e->getMessage());
    }
}

function modifySupplier($id, $supplierName, $contactPerson, $contactNumber) {
    try {
        $dbase = new Database();
        $formattedContactNumber = formatContactNumber($contactNumber);

        $stmt = $dbase->connect()->prepare("UPDATE supplier 
                                            SET SupplierName = :SupplierName, 
                                                ContactPerson = :ContactPerson, 
                                                ContactNumber = :ContactNumber 
                                            WHERE SupplierID = :id");
        
        if(!$stmt->execute([
            ':SupplierName' => $supplierName,
            ':ContactPerson' => $contactPerson,
            ':ContactNumber' => $formattedContactNumber,
            ':id' => $id
        ])) {
            $stmt = null;
            //header("location: ../pages/edit.php?error=inModifySupplier");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in modifySupplier:" . $e->getMessage());
    }
}

function modifyProduct($id, $productName, $supplierId, $price) {
    try {
        $dbase = new Database();

        $stmt = $dbase->connect()->prepare("UPDATE product 
                                            SET ProductName = :ProductName, 
                                                SupplierID = :SupplierID, 
                                                Price = :Price 
                                            WHERE ProductID = :id");
    
        if(!$stmt->execute([
            ':ProductName' => $productName,
            ':SupplierID' => $supplierId,
            ':Price' => $price,
            ':id' => $id
        ])){
            $stmt = null;
            //header("location: ../pages/edit.php?error=inModifyProduct");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in modifyProduct:" . $e->getMessage());
    }
}

function modifyOrder($id, $supplierIdPO, $orderDate, $deliveryDate) {
    try {
        $dbase = new Database();

        $formattedOrderDate = formatDate($orderDate);
        $formattedDeliveryDate = formatDate($deliveryDate);

        $stmt = $dbase->connect()->prepare("UPDATE purchaseorder 
                                            SET SupplierID = :SupplierID, 
                                                OrderDate = :OrderDate, 
                                                DeliveryDate = :DeliveryDate 
                                            WHERE OrderID = :id");
        
        if(!$stmt->execute([
            ':SupplierID' => $supplierIdPO,
            ':OrderDate' => $formattedOrderDate,
            ':DeliveryDate' => $formattedDeliveryDate,
            ':id' => $id
        ])) {
            $stmt = null;
            //header("location: ../pages/edit.php?error=inModifyOrder");
            exit();
        }
        $stmt = null;
    } catch (Exception $e) {
        die("Query Failed in modifyOrder:" . $e->getMessage());
    }
}


function deleteInfo($thisTable, $whichID, $id) {
    try {
        $dbase = new Database();
        $stmt = $dbase->connect()->prepare("DELETE FROM $thisTable WHERE $whichID = :id");
        
        if(!$stmt->execute([':id' => $id])) {
            $stmt = null;
            //header("location: ../pages/edit.php?error=inDeleteInfo");
            return false;
        } else {
            $stmt = null;
            return true;
        }
    } catch (Exception $e) {
        die("Query Failed in deleteInfo:" . $e->getMessage());
    }
}

// ID generators
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

    return $randomNumber;
}

function getNewProductID($db) {
    $randomId = createProductID();
    $existingProductIds = [];
    
    $stmt = $db->connect()->prepare("SELECT ProductID FROM product;");
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingProductIds[] = $row['ProductID'];
    }

    // Check if the random number already exists in the list of product IDs
    while (in_array($randomId, $existingProductIds)) {
        $randomId = createProductID();
    }

    return $randomId;
}

function createProductID() {
    // Generate a random letter from A to Z, and random number
    $randomLetter1 = chr(mt_rand(65, 90)); 
    $randomLetter2 = chr(mt_rand(65, 90));
    $randomNumber = mt_rand(10000, 99999);
    $id = $randomLetter1 . $randomLetter2 . "-" . $randomNumber;

    return $id;
}

function getNewOrderID($db) {
    $randomId = createOrderID();
    $existingOrderIds = [];

    $stmt = $db->connect()->prepare("SELECT OrderID FROM purchaseorder;");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingOrderIds[] = $row['OrderID'];
    }

    // Check if the random number already exists in the list of order IDs
    while (in_array($randomId, $existingOrderIds)) {
        $randomId = createProductID();
    }

    return $randomId;
}

function createOrderID() {
    $randomValue = uniqid(mt_rand(), true); // Generating a random unique identifier
    $hashedValue = md5($randomValue);
    $randomString = substr($hashedValue, 0, 8); // Truncate the hashed value to the desired length (e.g., 8 characters)
    $id = strtoupper($randomString);

    return $id;
}


function formatContactNumber($num) {
    $formatted = '0' . substr($num, 0, 3) . '-' . substr($num, 3, 3) . '-' . substr($num, 6, 4); 
    return $formatted;
}

function formatDate($date) {
    // Split the date string into an array
    $dateParts = explode('-', $date);
    $year = $dateParts[0];
    $month = ltrim($dateParts[1], '0');  // Remove leading zero
    $day = ltrim($dateParts[2], '0');    // Remove leading zero

    $formatted = $month . '/' . $day . '/' . $year;
    return $formatted;
}