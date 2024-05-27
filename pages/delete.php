<?php
    $show = $_GET['form'];
    $col = $_GET['col'];
    $id = $_GET['id'];

    function formatColumnName($columnName) {
        return preg_replace('/([a-z])([A-Z])/s','$1 $2', $columnName);
    }
?>

<div class="modal-header">
    <h5 class="modal-title fs-4 fw-bold" id="deleteModalLabel">Delete Data</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="container">
        <?php require_once '../includes/database.php';

        $dbase = new Database();
        $stmt = $dbase->connect()->prepare("SELECT * FROM $show WHERE $col = :id");

        $stmt->execute([':id' => $id]);

        // Fetch column names
        $columnCount = $stmt->columnCount();
        $columnNames = [];
        for ($i = 0; $i < $columnCount; $i++) {
            $columnMeta = $stmt->getColumnMeta($i);
            $columnNames[] = $columnMeta['name'];
        } ?>

        <table id="deleteTable" class="table table-hover table-pad">
            <thead class="table-head">
                <tr>
                    <?php foreach ($columnNames as $columnName) { ?>
                        <th><?php echo formatColumnName($columnName); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <?php foreach ($row as $value) { ?>
                            <td><?php echo $value; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <form id="deleteForm" method="post">                        
        <input type="hidden" id="dbId" value="<?php echo $id ?>">
        <input type="hidden" id="dbTable" value="<?php echo $show ?>">
        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete Row</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </form>
</div>

<?php
    unset($show);
    unset($col); 
    unset($id);
?>