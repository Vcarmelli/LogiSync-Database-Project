// FOR DATABASE MANIPULATION

function formSubmissionHandlers() {
    console.log("SCRIPT LOADED");
    $('#addSupplierForm').on('submit', addSupplier);
    $('#addProductForm').on('submit', addProduct);
    $('#addOrderForm').on('submit', addOrder);
}; 

function addSupplier(event) {
    event.preventDefault();

    // Get input values
    var supplierName = $('#supplierName').val();
    var contactPerson = $('#contactPerson').val();
    var contactNumber = $('#contactNumber').val();
    
    // Display the values (for example, logging to the console)
    console.log('Supplier Name:', supplierName);
    console.log('Contact Person:', contactPerson);
    console.log('Contact Number:', contactNumber);

    var data = {
        addSupplier: true,
        supplierName: supplierName,
        contactPerson: contactPerson,
        contactNumber: contactNumber,
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: data,
        success: function(response) {
            alert('Supplier added successfully!');
            console.error("success:", response);
            $('#addSupplierForm')[0].reset();
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error adding supplier');
        }
    });

};

function addProduct(event) {
    event.preventDefault();

    // Get input values
    var productName = $('#productName').val();
    var supplierId = $('#supplierId').val();
    var price = $('#price').val();
    
    // Display the values (for example, logging to the console)
    console.log('productName:', productName);
    console.log('supplierId:', supplierId);
    console.log('price:', price);

    var data = {
        addProduct: true,
        productName: productName,
        supplierId: supplierId,
        price: price,
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: data,
        success: function(response) {
            alert('Product added successfully!');
            $('#addProductForm')[0].reset();
        },
        error: function(error) {
            alert('Error adding product');
        }
    });

};

function addOrder(event) {
    event.preventDefault();

    // Get input values
    var supplierIdPO = $('#supplierIdPO').val();
    var orderDate = $('#orderDate').val();
    var deliveryDate = $('#deliveryDate').val();
    
    // Display the values (for example, logging to the console)
    console.log('supplierIdPO:', supplierIdPO);
    console.log('orderDate:', orderDate);
    console.log('deliveryDate:', deliveryDate);

    var data = {
        addOrder: true,
        supplierIdPO: supplierIdPO,
        orderDate: orderDate,
        deliveryDate: deliveryDate,
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: data,
        success: function(response) {
            alert('Product added successfully!');
            $('#addOrderForm')[0].reset();
        },
        error: function(error) {
            alert('Error adding product');
        }
    });
};