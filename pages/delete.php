<?php
    $show = isset($_GET['form']) ? $_GET['form'] : 'supplier'; 
    $id = isset($_GET['id']) ? $_GET['id'] : ''; 
?>

<?php if ($show === 'supplier'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="deleteSupplierModalLabel">Delete Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="deleteSupplierForm" method="post">
        <table id="supplierTable" class="table table-hover default-table table-pad">
            <thead class="table-dark">
                <tr>
                    <?php foreach (["Supplier ID", "Supplier Name", "Contact Person", "Contact Number", "Action"] as $columnName) { ?>
                        <th><?php echo $columnName; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            <?php
                require_once '../includes/database.php';

                $dbase = new Database();
                $stmt = $dbase->connect()->prepare('SELECT * FROM supplier');
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
                                <?php include '../components/edit_delete.php'; ?>
                            </tr>
                            <?php break;
                        }
                    }
                }
            ?>
            </tbody>
        </table>


            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <button type="submit" class="btn btn-primary">Update Supplier</button>
        </form>
    </div>