<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Supplier Form -->
    <form id="supplierForm" method="post" action="./includes/submit.php" class="container">
        <h2>Supplier Form</h2>
        <div class="mb-3">
            <label for="supplierName" class="form-label">Supplier Name</label>
            <input type="text" id="supplierName" name="supplierName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contactPerson" class="form-label">Contact Person</label>
            <input type="text" id="contactPerson" name="contactPerson" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contactNumber" class="form-label">Contact Number</label>
            <input type="text" id="contactNumber" name="contactNumber" class="form-control" required>
        </div>
        
        <button type="submit" id="addSupplier" name="addSupplier" class="btn btn-primary">Add Supplier</button>
    </form>

    <!-- Product Form -->
    <form id="productForm" method="post" action="./includes/submit.php" class="container">
        <h2>Product Form</h2>
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" id="productName" name="productName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="supplierId" class="form-label">Supplier ID</label>
            <input type="number" id="supplierId" name="supplierId" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" required>
        </div>
        
        <button type="submit" name="addProduct" class="btn btn-primary">Add Product</button>
    </form>

    <!-- Purchase Order Form -->
    <form id="orderForm" method="post" action="./includes/submit.php" class="container">
        <h2>Purchase Order Form</h2>
        <div class="mb-3">
            <label for="supplierIdPO" class="form-label">Supplier ID</label>
            <input type="number" id="supplierIdPO" name="supplierIdPO" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="orderDate" class="form-label">Order Date</label>
            <input type="date" id="orderDate" name="orderDate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="deliveryDate" class="form-label">Delivery Date</label>
        <input type="date" id="deliveryDate" name="deliveryDate" class="form-control" required>
        </div>
        
        <button type="submit" name="addOrder" class="btn btn-primary">Add Order</button>
    </form> 

    <script src="./backend/script.js"></script>
</body>
</html>