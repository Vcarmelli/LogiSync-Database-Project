<?php
    function formatColumnName($columnName) {
        return preg_replace('/([a-z])([A-Z])/s','$1 $2', $columnName);
    }
?>

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

    <table id="showRow" class="table table-hover table-pad ">
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