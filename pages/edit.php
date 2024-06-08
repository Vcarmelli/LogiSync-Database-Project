<?php
    $show = isset($_GET['form']) ? $_GET['form'] : 'supplier'; 
    $id = $_GET['id'];
?>

<?php if ($show === 'supplier'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateSupplierModalLabel">Edit Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div><?php  $col = 'SupplierID';
                    include '../components/row.php'; ?>
        </div>
        <form id="updateSupplierForm" method="post">
            <div class="mb-3">
                <label for="supplierNameUD" class="form-label">Supplier Name</label>
                <input type="text" class="form-control" id="supplierNameUD" name="supplierNameUD"  placeholder="Enter a new supplier name" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="contactPersonUD" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contactPersonUD" name="contactPersonUD"  placeholder="Enter a new contact person" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="contactNumberUD" class="form-label">Contact Number</label>
                <div class="input-group">
                    <span class="input-group-text">(+63)</span>
                    <input type="text" class="form-control" id="contactNumberUD" name="contactNumberUD"  placeholder="Enter a new contact number" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Update Supplier</button>
            </div>
        </form>
    </div>
<?php elseif ($show === 'product'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateProductModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div><?php  $col = 'ProductID';
                    include '../components/row.php'; ?>
        </div>
        <form id="updateProductForm" method="post">
            <div class="mb-3">
                <label for="productNameUD" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productNameUD" name="productNameUD" placeholder="Enter a new product name" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="supplierIdUD" class="form-label">Select Supplier</label>
                <select name="supplierIdUD" id="supplierIdUD" class="form-select" placeholder="Choose a new supplier" required>
                    <?php
                        require_once '../includes/database.php';
                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT SupplierID, SupplierName FROM supplier ORDER BY SupplierID;');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['SupplierID'] . '">' . $row['SupplierID'] . ' - ' . $row['SupplierName'] . '</option>';
                        }
                    ?>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="priceUD" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">&#8369;</span>
                    <input type="number" step="0.01" class="form-control" id="priceUD" name="priceUD" placeholder="Enter a new price" required>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="mb-3">
                <label for="quantityUD" class="form-label">Quantity</label>
                <input type="number" step="1" min="0" class="form-control" id="quantityUD" name="quantityUD" placeholder="Enter a new quantity" required>
                <div class="invalid-feedback"></div>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
<?php elseif ($show === 'purchaseorder'): ?>
    <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="updateOrderModalLabel">Edit Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div><?php  $col = 'OrderID';
                    include '../components/row.php'; ?>
        </div>
        <form id="updateOrderForm" method="post">
            <div class="mb-3">
                <label for="supplierIdPOUD" class="form-label">Select Supplier</label>
                <select name="supplierIdPOUD" id="supplierIdPOUD" class="form-select" placeholder="Choose a new supplier" required>
                    <?php
                        require_once '../includes/database.php';
                        $dbase = new Database();
                        $stmt = $dbase->connect()->prepare('SELECT SupplierID, SupplierName FROM supplier ORDER BY SupplierID;');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['SupplierID'] . '">' . $row['SupplierID'] . ' - ' . $row['SupplierName'] . '</option>';
                        }
                    ?>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3" id="supplierProductsUD">
            </div>
            <div class="mb-3">
                <label for="orderDateUD" classf="form-label">Order Date</label>
                <input type="date" class="form-control" id="orderDateUD" name="orderDateUD" placeholder="Enter a new order date" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3">
                <label for="deliveryDateUD" class="form-label">Delivery Date</label>
                <input type="date" class="form-control" id="deliveryDateUD" name="deliveryDateUD" placeholder="Enter a new delivery date" required>
                <div class="invalid-feedback"></div>
            </div>
            <input type="hidden" id="dbTable" value="<?php echo $show ?>">
            <div class="modal-footer pt-4">
                <button type="submit" class="btn btn-primary">Update Order</button>
            </div>
        </form>
    </div>
<?php endif; 

unset($show); ?>