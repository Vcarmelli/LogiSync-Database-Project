<?php

include 'database.php';

if(isset($_POST["getProducts"])) {
    $supplierID = $_POST["supplierID"];

    $dbase = new Database();
    $stmt = $dbase->connect()->prepare('SELECT product.ProductName, product.Price, supplier.SupplierName, supplier.ContactNumber 
                                        FROM product 
                                        INNER JOIN supplier ON product.SupplierID = supplier.SupplierID 
                                        WHERE product.SupplierID = :supplier_id');
    $stmt->bindParam(':supplier_id', $supplierID);
    $stmt->execute();
    
    // Fetch results
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $productList = json_encode($products);
    // echo $productList;
    //Output results
    if ($products) {
        echo '<h2>Products from Supplier</h2>';
        echo '<ul>';
        foreach ($products as $product) {
            echo '<li>';
            echo 'Product Name: ' . $product['ProductName'] . '<br>';
            echo 'Price: ' . $product['Price'] . '<br>';
            echo 'Supplier Name: ' . $product['SupplierName'] . '<br>';
            echo 'Contact Number: ' . $product['ContactNumber'] . '<br>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No products found for the selected supplier.';
    }
}