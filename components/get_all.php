<?php 

require_once '../includes/database.php';
@session_start();

$itemsPerPage = 10;
$dbase = new Database();

$whichTable =  isset($_GET['table']) ? $_GET['table'] : $whichTable;

$stmt = $dbase->connect()->query('SELECT COUNT(*) FROM ' . $whichTable);

$totalItems = $stmt->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max($currentPage, 1); // Ensure current page is not less than 1
$currentPage = min($currentPage, $totalPages); // Ensure current page is not more than total pages

$offset = ($currentPage - 1) * $itemsPerPage;

// Fetch the items for the current page
$query = 'SELECT * FROM ' . $whichTable . ' LIMIT :offset, :itemsPerPage';
$stmt = $dbase->connect()->prepare($query);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();

$firstColumn = null;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    if ($row) {
        foreach ($row as $column => $value) {
            $firstColumn = $column; ?>
            <tr>
                <input class="rowID" type="hidden" value="<?php echo $row[$firstColumn]; ?>">
                <?php foreach ($row as $value) { ?>
                    <td><?php echo $value; ?></td>
                <?php } ?>

                <?php if ($whichTable === 'product'): ?>
                    <?php if ($row['Quantity'] == 0): ?>
                        <td><div class="stock-out">Out of Stock</div></td>
                    <?php else: ?>
                        <td><div class="stock-in">In Stock</div></td>
                    <?php endif ?>

                <?php elseif ($whichTable === 'purchaseorder'): ?>
                    <td><button type="button" class="print btn btn-print">Print</button></td>
                <?php endif ?>

                <?php if ($_SESSION["type"] === 'admin'): 
                    include '../components/edit_delete.php'; 
                endif ?>                    
            </tr>
            <?php break; 
        }
    }
}
?>