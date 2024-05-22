// FOR DATABASE MANIPULATION

function formSubmissionHandlers() {
    console.log("SCRIPT LOADED");
    $('#addSupplierForm').on('submit', addRow);
    $('#addProductForm').on('submit', addRow);
    $('#addOrderForm').on('submit', addRow);
}; 

function formModificationHandlers() {
    console.log("MODIFY TABLE");

    $('#updateSupplierForm').on('submit', editRow);
    $('#updateProductForm').on('submit', editRow);
    $('#updateOrderForm').on('submit', editRow);

    $('#deleteSupplierForm').on('submit', deleteRow);
    $('#deleteProductForm').on('submit', deleteRow);
    $('#deleteOrderForm').on('submit', deleteRow);

    // $('#supplierTable').on('click', '.edit', editRow);
    // $('#supplierTable').on('click', '.delete', deleteRow);
    // $('#productTable').on('click', '.edit', editRow);
    // $('#productTable').on('click', '.delete', deleteRow);
    // $('#orderTable').on('click', '.edit', editRow);
    // $('#orderTable').on('click', '.delete', deleteRow);
}

function clearForm() {
    console.log("FORM CLEARED");
    $('#addSupplierForm')[0].reset();
    $('#addProductForm')[0].reset();
    $('#addOrderForm')[0].reset();
}; 

function editRow(event) {
    event.preventDefault(); 
    
    var table = $(this).closest('table').attr('id');
    var rowID = $(this).closest('tr').find('.rowID').val();
    console.log('Edit ID:', rowID, 'from', table);

    const data = getData(table);
    console.log('Data:', data);

    const sendData = {
        action: 'edit', 
        table: table,
        id: rowID,
        data: data
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: sendData,
        success: function(response) {
            console.log("success:", response);
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error editing', table);
        }
    });

    
}

function deleteRow(event) {
    event.preventDefault();
    var table = $(this).closest('table').attr('id');
    var rowID = $(this).closest('tr').find('.rowID').val();
    console.log('Delete ID:', rowID, 'from', table);

    const sendData = {
        action: 'delete', 
        table: table,
        id: rowID,
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: sendData,
        success: function(response) {
            console.log("success:", response);
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error deleting', table);
        }
    });
}


function addRow(event) {
    event.preventDefault();
    var table = $(this).closest('form').attr('id');

    const data = getData(table);
    console.log('Data:', data);
    

    const supplierData = {
        action: 'add',
        table: table,
        data: data
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: supplierData,
        success: function(response) {
            alert('Added successfully!');
            //clearForm();
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error adding');
        }
    });

};

// function addProduct(event) {
//     event.preventDefault();

//     const data = getData("productTable");
    
//     // Display the values (for example, logging to the console)
//     console.log('productName:', data.productName);
//     console.log('supplierId:', data.supplierId);
//     console.log('price:', data.price);

//     const productData = {
//         action: 'addProduct',
//         data: data
//     }

//     $.ajax({
//         type: 'POST',
//         url: '../includes/submit.php',
//         data: productData,
//         success: function(response) {
//             alert('Product added successfully!');
//             $('#addProductForm')[0].reset();
//         },
//         error: function(error) {
//             console.error("Error:", error);
//             alert('Error adding product');
//         }
//     });

// };

// function addOrder(event) {
//     event.preventDefault();

//     const data = getData("orderTable");
    
//     // Display the values (for example, logging to the console)
//     console.log('supplierIdPO:', supplierIdPO);
//     console.log('orderDate:', orderDate);
//     console.log('deliveryDate:', deliveryDate);

//     const orderData = {
//         action: 'addOrder',
//         data: data
//     }

//     $.ajax({
//         type: 'POST',
//         url: '../includes/submit.php',
//         data: orderData,
//         success: function(response) {
//             alert('Product added successfully!');
//             $('#addOrderForm')[0].reset();
//         },
//         error: function(error) {
//             console.error("Error:", error);
//             alert('Error adding product');
//         }
//     });
//};


function getData(table) {
    var data = {}; 
    if(table === "supplierTable" || table === "addSupplierForm") {
        data = getSupplierData();
    } else if(table === "productTable" || table === "addProductForm") {
        data = getProductData();
    } else if(table === "orderTable" || table === "addOrderForm") {
        data = getOrderData();
    }
    return data
}

// getters
function getSupplierData() {
    const data = {
        supplierName: $('#supplierName').val(),
        contactPerson: $('#contactPerson').val(),
        contactNumber: $('#contactNumber').val()
    }
    return data
}

function getOrderData() {
    const data = {
        supplierIdPO: $('#supplierIdPO').val(),
        orderDate: $('#orderDate').val(),
        deliveryDate: $('#deliveryDate').val()
    }
    return data
}

function getProductData() {
    const data = {
        productName: $('#productName').val(),
        supplierId: $('#supplierId').val(),
        price: $('#price').val()
    }
    return data
}