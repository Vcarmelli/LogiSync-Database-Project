<?php
    $supplierID = isset($_GET['supplierId']) ? $_GET['supplierId'] : '';
?>

<table id="prodsQuantity" class="table table-hover table-pad mt-3 mb-5">
    <thead class="table-head">
        <tr>
            <th>Product Name</th>
            <th class="col-sm-5">Quantity</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
            require_once '../includes/database.php';
            $dbase = new Database();
            $stmt = $dbase->connect()->prepare('SELECT ProductID, ProductName FROM product WHERE SupplierID = ?;');
            if($stmt->execute([$supplierID])) {
                if($stmt->rowCount() > 0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['ProductName']) . '</td>';
                        echo '<td><input type="number" name="' . htmlspecialchars($row['ProductID']) . '" value="1" min="0" class="form-control quantity"></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No products found.</td></tr>';
                }
            } else {
                echo '<tr><td colspan="2">No products found.</td></tr>';
            }
        ?>
    </tbody>
</table>