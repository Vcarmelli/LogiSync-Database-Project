<?php
    $show = isset($_GET['form']) ? $_GET['form'] : 'supplier'; 
?>

<?php if ($show === 'supplier'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="addSupplierModalLabel">Add Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="addSupplierForm" method="post">
            <div class="mb-3">
                <label for="supplierName" class="form-label">Supplier Name</label>
                <input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="Enter a supplier name" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="contactPerson" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contactPerson" name="contactPerson" placeholder="Enter a contact person's name" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <div class="input-group">
                    <span class="input-group-text">(+63)</span>
                    <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter a contact number" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Add Supplier</button>
            </div>
        </form>
    </div>
<?php elseif ($show === 'product'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="addProductModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="addProductForm" method="post">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter a product name" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="supplierId" class="form-label">Select Supplier</label>
                <select name="supplierId" id="supplierId" class="form-select" placeholder="Choose a supplier" required>
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
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">&#8369;</span>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter a price" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" step="1" min="0" class="form-control" id="quantity" name="quantity" placeholder="Enter a quantity" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
<?php elseif ($show === 'purchaseorder'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="addOrderModalLabel">Add Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="addOrderForm" method="post">
            <div class="mb-3">
                <label for="supplierIdPO" class="form-label">Select Supplier</label>
                <select name="supplierIdPO" id="supplierIdPO" class="form-select" placeholder="Choose a supplier" required>
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
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3" id="supplierProducts">
            </div>
            <div class="mb-3">
                <label for="orderDate" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="orderDate" name="orderDate" placeholder="Enter a order date" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="deliveryDate" class="form-label">Delivery Date</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" placeholder="Enter a delivery date" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Add Order</button>
            </div>
        </form>
    </div>
<?php endif; 

unset($show)?>