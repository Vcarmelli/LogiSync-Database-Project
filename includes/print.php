<?php

require_once '../includes/database.php';
require_once '../vendor/autoload.php';

if (isset($_GET['print'])) {
    $id = $_GET['id'];

    $dbase = new Database();
    $stmt = $dbase->connect()->prepare("SELECT 
                                            S.SupplierID,
                                            S.SupplierName,
                                            S.ContactPerson,
                                            S.ContactNumber,
                                            P.ProductID,
                                            P.ProductName,
                                            P.Price,
                                            PO.OrderID,
                                            PO.OrderDate,
                                            PO.DeliveryDate
                                        FROM 
                                            supplier S
                                        JOIN 
                                            product P ON S.SupplierID = P.SupplierID
                                        JOIN 
                                            purchaseorder PO ON S.SupplierID = PO.SupplierID
                                        WHERE 
                                            PO.OrderID = :id
                                        ");

    $stmt->execute([':id' => $id]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //echo json_encode($row);

    openPrinter($row);
}

function openPrinter($rows) {
    $mpdf = new \Mpdf\Mpdf();

    $total = 0;
    $orderInfo = $rows[0];
    $titleHtml = '<h1 align="center">LogiSync</h1>';
    $titleHtml .= '<h1 align="center">Order Invoice</h1>';

    // Build HTML for order information (upper right)
    $orderHtml = '<div style="position: absolute; top: 180px; right: 80px;">';
    $orderHtml .= '<h4>Order ID: ' . $orderInfo['OrderID'] . '</h4>';
    $orderHtml .= '<p>Order Date: ' . $orderInfo['OrderDate'] . '</p>';
    $orderHtml .= '<p>Delivery Date: ' . $orderInfo['DeliveryDate'] . '</p>';
    $orderHtml .= '</div>';

    // Build HTML for supplier information (upper left)
    $supplierHtml = '<div style="position: absolute; top: 180px; left: 70px;">';
    $supplierHtml .= '<h4>' . $orderInfo['SupplierName'] . '</h4>';
    $supplierHtml .= '<p>Supplier ID: ' . $orderInfo['SupplierID'] . '</p>';
    $supplierHtml .= '<p>Contact Person: ' . $orderInfo['ContactPerson'] . '</p>';
    $supplierHtml .= '<p>Contact Number: ' . $orderInfo['ContactNumber'] . '</p>';
    $supplierHtml .= '</div>';

    // Build HTML for product table (below)
    $tableHtml = '<div align="center" style="margin-top: 220px; margin-left: 150px">';
    $tableHtml .= '<h2>Product Information</h2>';
    $tableHtml .= '<table border="0" cellpadding="20">';
    $tableHtml .= '<tr><th>Product ID</th><th>Product Name</th><th>Price</th></tr>';

    // Iterate over each product and add row to the table
    foreach ($rows as $row) {
        $tableHtml .= '<tr>';
        $tableHtml .= '<td>' . $row['ProductID'] . '</td>';
        $tableHtml .= '<td>' . $row['ProductName'] . '</td>';
        $tableHtml .= '<td>' . $row['Price'] . '</td>';
        $tableHtml .= '</tr>';
        $total += $row['Price'];
    }

    // Close the table
    $tableHtml .= '</table>';

    // Add space for total price
    $tableHtml .= '<div align="center" style="margin-top: 20px;">';
    $tableHtml .= '<h3>Total Price:  ₱' . $total . '</h3>';
    $tableHtml .= '</div>';

    // Close the div for the product table
    $tableHtml .= '</div>';

    // Combine HTML for order, supplier, and table
    $html = $titleHtml . $orderHtml . $supplierHtml . $tableHtml;

    // Add the HTML markup to the PDF
    $mpdf->WriteHTML($html);

    // Output the PDF
    ob_clean(); 
    $mpdf->Output('invoice.pdf', 'D');
}

