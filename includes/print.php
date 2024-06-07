<?php
    $orderID = isset($_GET['id']) ? $_GET['id'] : '';

    require_once '../includes/database.php';
    $dbase = new Database();
    $stmt = $dbase->connect()->prepare("SELECT 
                                            S.SupplierID,
                                            S.SupplierName,
                                            S.ContactPerson,
                                            S.ContactNumber,
                                            P.ProductID,
                                            P.ProductName,
                                            P.Price,
                                            PO.OrderID,
                                            PO.OrderDate,
                                            PO.DeliveryDate
                                        FROM 
                                            supplier S
                                        JOIN 
                                            product P ON S.SupplierID = P.SupplierID
                                        JOIN 
                                            purchaseorder PO ON S.SupplierID = PO.SupplierID
                                        WHERE 
                                            PO.OrderID = :id
                                        ");

    $stmt->execute([':id' => $id]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="modal-header">
    <h5 class="modal-title fs-4 fw-bold" id="invoiceModalLabel">Order Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="orderDetails" method="post">
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
        <input type="hidden" id="dbTable" value="">
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Print Invoice</button>
        </div>
    </form>
</div>