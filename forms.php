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
    <form id="supplierForm" method="post" action="./includes/submit.php">
        <h2>Supplier Form</h2>
        <label for="supplierName">Supplier Name:</label>
        <input type="text" id="supplierName" name="supplierName" required>
        <label for="contactPerson">Contact Person:</label>
        <input type="text" id="contactPerson" name="contactPerson">
        <label for="contactNumber">Contact Number:</label>
        <input type="text" id="contactNumber" name="contactNumber">
        <button type="submit">Submit</button>
    </form>

    <!-- Product Form 
    <form id="productForm">
        <h2>Product Form</h2>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>
        <label for="supplierId">Supplier ID:</label>
        <input type="number" id="supplierId" name="supplierId" required>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <button type="submit">Submit</button>
    </form>

    <!-- Purchase Order Form 
    <form id="purchaseOrderForm">
        <h2>Purchase Order Form</h2>
        <label for="supplierIdPO">Supplier ID:</label>
        <input type="number" id="supplierIdPO" name="supplierIdPO" required>
        <label for="orderDate">Order Date:</label>
        <input type="date" id="orderDate" name="orderDate" required>
        <label for="deliveryDate">Delivery Date:</label>
        <input type="date" id="deliveryDate" name="deliveryDate">
        <button type="submit">Submit</button>
    </form>

    -->
</body>
</html>