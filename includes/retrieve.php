<?php

include 'database.php';

if($_GET['view'] == 'charts') {

    try {
        // Fetch data for products with each supplier
        $dbase = new Database();
    
        // Fetch data for orders placed with each supplier
        $stmt = $dbase->connect()->query('SELECT SupplierName, COUNT(OrderID) AS OrderCount 
                                          FROM supplier LEFT JOIN purchaseorder ON supplier.SupplierID = purchaseorder.SupplierID 
                                          GROUP BY Supplier.SupplierID
                                          ORDER BY OrderCount DESC 
                                          LIMIT 5');
        $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $data = [ 'orders' => $orderData ];

        //header('Content-Type: application/json');
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

        //header('Content-Type: application/json');
        echo json_encode($data);

    } catch (Exception $e) {
        die("Query Failed in retrieve.php:" . $e->getMessage());
    }


} else if($_GET['view'] == 'average') {
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

} else if($_GET['view'] == 'range') {
    try {
        $dbase = new Database();

        $stmt = $dbase->connect()->query("SELECT CASE
                                            WHEN price < 300 THEN '₱0 - ₱300'
                                            WHEN price >= 300 AND Price < 600 THEN '₱300 - ₱600'
                                            WHEN Price >= 600 AND Price < 1000 THEN '₱600 - ₱1000'
                                            ELSE '₱1000+'
                                            END AS PriceRange,
                                            COUNT(ProductID) AS ProductCount
                                        FROM product
                                        GROUP BY PriceRange
                                        ORDER BY PriceRange;");

        $productRanges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $formattedData = [];

        // Loop through the fetched data and format it
        foreach ($productRanges as $range) {
            $formattedData[] = [
                'PriceRange' => $range['PriceRange'],
                'ProductCount' => (int) $range['ProductCount'] // Ensure ProductCount is an integer
            ];
        }
        echo json_encode($formattedData);
        
    } catch (Exception $e) {
        die("Query Failed in retrieve.php RANGE:" . $e->getMessage());
    }

}
    
