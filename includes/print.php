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
                                            P.Quantity,
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
                                            PO.OrderID = :orderID
                                        ");

    $stmt->execute([':orderID' => $orderID]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = 0;
?>
    
<div class="modal-header">
    <h5 class="modal-title fs-4 fw-bold" id="invoiceModalLabel">Order Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="invoice-container modal-body">
    <div class="text-center mb-3">
        <img src="../assets/logisync.png" alt="LogiSync" height="70">
        <h1 class="">Order Invoice</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div>
            <p class="m-0 fw-bold"><?= htmlspecialchars($rows[0]['SupplierName']) ?></p>
            <p>Supplier ID: <?= htmlspecialchars($rows[0]['SupplierID']) ?></p>
        </div>
        <div class="text-end">
            <p class="m-0 fw-bold"><?= htmlspecialchars($rows[0]['ContactPerson']) ?></p>
            <p><?= htmlspecialchars($rows[0]['ContactNumber']) ?></p>
        </div>
    </div>
    <div class="mb-3">
        <p class="m-0"><b>Order Date:</b> <?= htmlspecialchars($rows[0]['OrderDate']) ?></p>
        <p><b>Delivery Date:</b> <?= htmlspecialchars($rows[0]['DeliveryDate']) ?></p>
    </div>
    <div class="mb-3">
        <table class="table table-hover default-table table-pad">
        <thead class="table-head">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): 
                    $productTotal = $row['Price'] * $row['Quantity'];
                    $total += $productTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ProductID']) ?></td>
                        <td><?= htmlspecialchars($row['ProductName']) ?></td>
                        <td>&#8369;<?= htmlspecialchars($row['Price']) ?></td>
                        <td><?= htmlspecialchars($row['Quantity']) ?></td>
                        <td>&#8369;<?= htmlspecialchars($productTotal) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="foot fw-bold">
                    <td>Grand Total</td>
                    <td class="text-end" colspan="4">&#8369;<?= htmlspecialchars($total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal-footer pt-4">
    <button type="submit" class="btn btn-primary print-btn">Print Invoice</button>
</div>
