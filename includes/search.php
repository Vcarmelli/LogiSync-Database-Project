<?php

session_start();
require_once 'database.php';

if (isset($_GET['action']) && $_GET['action'] == 'search') {
    $filterValues = $_GET['searchInput'];
    $whichTable = $_GET['searchTable'];
    $searchColumns = $_GET['searchColumns'];
    $checkColumns = implode(',', $searchColumns);

    $dbase = new Database();
    // Get the columns of the table
    $getColumns = $dbase->connect()->prepare("SHOW COLUMNS FROM $whichTable");
    $getColumns->execute();
    $columns = $getColumns->fetchAll(PDO::FETCH_COLUMN);
    $columns = additionalColumns($whichTable, $columns);

    // Prepare the search query
    $stmt = $dbase->connect()->prepare("SELECT * FROM $whichTable WHERE CONCAT($checkColumns) LIKE :filterValues;");
    $stmt->bindValue(':filterValues', "%$filterValues%", PDO::PARAM_STR);
    $stmt->execute();
    $tableId = assignId($whichTable);
    echo '<table id="' . $tableId . '" class="table table-hover table-pad">';
    echo '<thead class="table-head"><tr>';
    foreach ($columns as $column) {
        echo "<th>" . htmlspecialchars(formatColumnName($column), ENT_QUOTES, 'UTF-8') . "</th>";
    }
    echo '</tr></thead>';
    echo '<tbody class="table-group-divider">';

    $firstColumn = null;
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results){
            $firstColumn = $columns[0];

            foreach ($results as $row) {
                echo '<tr class="results-row">';
                echo '<input class="rowID" type="hidden" value="' . htmlspecialchars($row[$firstColumn], ENT_QUOTES, 'UTF-8') . '">';

                // Output table data for each column
                foreach ($row as $value) {
                    echo '<td>' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</td>';
                }
                if ($whichTable === 'product') {
                    if ($row['Quantity'] == 0){
                        echo '<td><div class="stock-out">Out of Stock</div></td>';
                    } else {
                        echo '<td><div class="stock-in">In Stock</div></td>';
                    }
                }
                if ($whichTable === 'purchaseorder'){
                    echo '<td><button type="button" class="print btn btn-print mx-2">Print</button></td>';
                }
                if ($_SESSION["type"] === 'admin') {
                    include '../components/edit_delete.php';
                }
                echo '</tr>';
            }
        }
    } else {
    // If no records found, display a single row with colspan
    echo "<tr><td colspan='" . count($columns) . "'>No matching records found</td></tr>";
    }
    echo '</tbody></table>';
}


function formatColumnName($columnName) {
    // Convert camelCase or PascalCase to spaced words
    return preg_replace('/([a-z])([A-Z])/s','$1 $2', $columnName);
}

function assignId($table) {
    switch ($table) {
        case 'supplier':
            return "supplierTable";
        case 'product':
            return "productTable";
        case 'purchaseorder':
            return "orderTable";
        default:
            break;
    }
}

function additionalColumns($table, $col) {
    $columns = $col;
    switch ($table) {
        case 'supplier':
            break;
        case 'product':
            $columns[] = "Status";
            break;
        case 'purchaseorder':
            $columns[] = "Details";
            break;
        default:
            break;
    }
    if ($_SESSION["type"] === 'admin') {
        $columns[] = "Action";
    }
    return $columns;
}
