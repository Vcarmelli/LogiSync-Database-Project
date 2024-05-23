<?php

include 'database.php';

if($_GET['view'] == 'charts') {

    try {
        // Fetch data for products with each supplier
        $dbase = new Database();

        $stmt = $dbase->connect()->query('SELECT SupplierName FROM supplier');
        $supplierData = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $stmt = $dbase->connect()->query('SELECT SupplierName, COUNT(ProductID) AS ProductCount 
                                          FROM supplier LEFT JOIN product ON supplier.SupplierID = product.SupplierID 
                                          GROUP BY supplier.SupplierID');

        $productData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch data for orders placed with each supplier
        $stmt = $dbase->connect()->query('SELECT SupplierName, COUNT(OrderID) AS OrderCount 
                                          FROM supplier LEFT JOIN purchaseorder ON supplier.SupplierID = purchaseorder.SupplierID 
                                          GROUP BY Supplier.SupplierID');
        $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo $supplierData;
        // echo $productData;
        // echo $orderData;

        $data = [
            'suppliers' => $supplierData,
            'products' => $productData,
            'orders' => $orderData
        ];

        header('Content-Type: application/json');
        echo json_encode($data);

    } catch (Exception $e) {
        die("Query Failed in retrieve.php:" . $e->getMessage());
    }
    
} else if($_GET['view'] == 'counts') {
    try {
        // Fetch data for products with each supplier
        $dbase = new Database();

        // Fetch supplier count
        $stmt = $dbase->connect()->query('SELECT COUNT(SupplierID) AS supCount FROM supplier');
        $supCount = $stmt->fetch(PDO::FETCH_ASSOC)['supCount'];

        // Fetch product count
        $stmt = $dbase->connect()->query('SELECT COUNT(ProductID) AS proCount FROM product');
        $proCount = $stmt->fetch(PDO::FETCH_ASSOC)['proCount'];

        // Fetch order count
        $stmt = $dbase->connect()->query('SELECT COUNT(OrderID) AS ordCount FROM purchaseorder');
        $ordCount = $stmt->fetch(PDO::FETCH_ASSOC)['ordCount'];

        $data = [
            'suppliers' => $supCount,
            'products' => $proCount,
            'orders' => $ordCount
        ];

        header('Content-Type: application/json');
        echo json_encode($data);

    } catch (Exception $e) {
        die("Query Failed in retrieve.php:" . $e->getMessage());
    }


} else if($_GET['view'] == 'average' || $_GET['view'] == 'monthly')  {
    try {
        $dbase = new Database();

        // Fetch data from PurchaseOrder table
        $stmt = $dbase->connect()->query('SELECT * FROM purchaseorder');
        $purchaseOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        // Fetch data from Supplier table
        $stmt = $dbase->connect()->query('SELECT * FROM supplier');
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
        $data = [
            'purchaseOrders' => $purchaseOrders,
            'suppliers' => $suppliers
        ];
        echo json_encode($data);
        
    } catch (\PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
    
