<?php

session_start();
require_once '../includes/database.php';

if (isset($_GET['action']) && $_GET['action'] == 'orderbymonth') {
    try {
        $dbase = new Database();
        $db = $dbase->connect();
        
        $selectedMonth = $_GET['month'];
        
        $stmt = $db->prepare('SELECT * FROM purchaseorder WHERE MONTH(STR_TO_DATE(OrderDate, "%m/%d/%Y")) = :selectedMonth');
        $stmt->bindParam(':selectedMonth', $selectedMonth, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            foreach ($results as $row) {
                echo '<tr>';
                echo '<input class="rowID" type="hidden" value="' . $row['OrderID'] . '">';
                foreach ($row as $column => $value) {
                    echo '<td>' . htmlspecialchars($value) . '</td>';
                }
                echo '<td><button type="button" class="print btn btn-print" data-bs-toggle="modal" data-bs-target="#dynamicPrintModal">View Details</button></td>';
                if (isset($_SESSION["type"]) && $_SESSION["type"] === 'admin') {
                    $whichTable = "purchaseorder";
                    include '../components/edit_delete.php'; 
                }
                
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No orders found for the selected month.</td></tr>';
        }
    } catch (Exception $e) {
        echo '<tr><td colspan="5">Error: ' . $e->getMessage() . '</td></tr>';
    }
}
                        