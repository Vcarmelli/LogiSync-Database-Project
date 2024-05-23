<?php
    $show = isset($_GET['form']) ? $_GET['form'] : 'supplier'; 
?>

<?php if ($show === 'supplier'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateSupplierModalLabel">Edit Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="updateSupplierForm" method="post">
            <div class="mb-3">
                <label for="supplierName" class="form-label">Supplier Name</label>
                <input type="text" class="form-control" id="supplierName" name="supplierName" required>
            </div>
            <div class="mb-3">
                <label for="contactPerson" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contactPerson" name="contactPerson" required>
            </div>
            <div class="mb-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <div class="input-group">
                    <span class="input-group-text">(+63)</span>
                    <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
                </div>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <button type="submit" class="btn btn-primary">Update Supplier</button>
        </form>
    </div>
<?php elseif ($show === 'product'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateProductModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="updateProductForm" method="post">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
                <label for="supplierId" class="form-label">Select Supplier</label>
                <select name="supplierId" id="supplierId" class="form-select" required>
                    <?php
                        require_once '../includes/database.php';
                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT SupplierID, SupplierName FROM supplier ORDER BY SupplierName;');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['SupplierID'] . '">' . $row['SupplierName'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">&#8369;</span>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
<?php elseif ($show === 'purchaseorder'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateOrderModalLabel">Edit Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="updateOrderForm" method="post">
            <div class="mb-3">
                <label for="supplierIdPO" class="form-label">Select Supplier</label>
                <select name="supplierIdPO" id="supplierIdPO" class="form-select" required>
                    <?php
                        require_once '../includes/database.php';
                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT SupplierID, SupplierName FROM supplier ORDER BY SupplierName;');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['SupplierID'] . '">' . $row['SupplierName'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="orderDate" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="orderDate" name="orderDate" required>
            </div>
            <div class="mb-3">
                <label for="deliveryDate" class="form-label">Delivery Date</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" required>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <button type="submit" class="btn btn-primary">Update Order</button>
        </form>
    </div>
<?php endif; 

unset($show); ?>