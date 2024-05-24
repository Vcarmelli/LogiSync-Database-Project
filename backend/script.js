// FOR DATABASE MANIPULATION

function formSubmissionHandlers() {
    console.log("SCRIPT LOADED");
    $('#addSupplierForm').on('submit', addRow);
    $('#addProductForm').on('submit', addRow);
    $('#addOrderForm').on('submit', addRow);
}; 

function formModificationHandlers(rowID) {
    console.log("MODIFY TABLE");
    
    $('#updateSupplierForm').on('submit', function(event) { editRow(event, rowID); });
    $('#updateProductForm').on('submit', function(event) { editRow(event, rowID); });
    $('#updateOrderForm').on('submit', function(event) { editRow(event, rowID); });

    $('#deleteForm').on('submit', function(event) { deleteRow(event, rowID); });
}

function addClearForm() {
    console.log("ADD FORM CLEARED");
    $('#addSupplierForm')[0].reset();
    $('#addProductForm')[0].reset();
    $('#addOrderForm')[0].reset();

    // try {
    //     if ($('#addSupplierForm').length > 0) {
    //         $('#addSupplierForm')[0].reset();
    //         console.log("CLEARED");
    //     } else {
    //         throw new Error('Form not found');
    //     }
    // } catch (error) {
    //     console.error(error);
    // }
}; 

function updateClearForm() {
    console.log("UPDATE FORM CLEARED");
    $('#updateSupplierForm')[0].reset();
    $('#updateProductForm')[0].reset();
    $('#updateOrderForm')[0].reset();
}; 

function deleteClearForm() {
    console.log("DELETE FORM CLEARED");
    $('#deleteForm')[0].reset();
}; 


function addRow(event) {
    event.preventDefault();
    var table = $(this).closest('form').attr('id');

    const data = getData(table);
    console.log('Data:', data);
    
    const tableData = {
        action: 'add',
        table: table,
        data: data
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: tableData,
        success: function(response) {
            console.log(response);
            triggerAlert(response);
            addClearForm();
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });

};


function editRow(event, rowID) {
    event.preventDefault(); 
    
    var table = $('#dbTable').val()
    console.log('Edit ID:', rowID, 'from', table);

    const data = getUpdatedData(table);
    console.log('Data:', data);

    const sendData = {
        action: 'edit', 
        table: table,
        id: rowID,
        data: JSON.stringify(data)
    }

    $.ajax({
        type: 'POST',
        url: '../includes/submit.php',
        data: sendData,
        success: function(response) {
            console.log(response);
            triggerAlert(response);
            updateClearForm();
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error editing', table);
        }
    });
}


function deleteRow(event, rowID) {
    event.preventDefault();

    var table = $('#dbTable').val()
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
            console.log(response);
            triggerAlert(response);
            deleteClearForm();
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error deleting', table);
        }
    });
}



// getters
function getData(table) {
    var data = {}; 
    if(table === "addSupplierForm") {
        data = getSupplierData();
    } else if(table === "addProductForm") {
        data = getProductData();
    } else if(table === "addOrderForm") {
        data = getOrderData();
    }
    return data
}

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

function getUpdatedData(table) {
    var data = {}; 
    if(table === "supplier") {
        data = getUDSupplierData();
    } else if(table === "product") {
        data = getUDProductData();
    } else if(table === "order") {
        data = getUDOrderData();
    }
    return data
}

function getUDSupplierData() {
    const data = {
        supplierName: $('#supplierNameUD').val(),
        contactPerson: $('#contactPersonUD').val(),
        contactNumber: $('#contactNumberUD').val()
    }
    return data
}

function getUDOrderData() {
    const data = {
        supplierIdPO: $('#supplierIdPOUD').val(),
        orderDate: $('#orderDateUD').val(),
        deliveryDate: $('#deliveryDateUD').val()
    }
    return data
}

function getUDProductData() {
    const data = {
        productName: $('#productNameUD').val(),
        supplierId: $('#supplierIdUD').val(),
        price: $('#priceUD').val()
    }
    return data
}


function triggerAlert(response) {
    console.log("response:", response);
    if(response == 'true') {
        $('#alert-success').removeClass('d-none');
        $('#alert-error').addClass('d-none');
        //hideAlerts();
    } else {
        $('#alert-error').removeClass('d-none');
        $('#alert-success').addClass('d-none');
        //hideAlerts();
    }
}

function hideAlerts() {
    setTimeout(function() {
        $('#alert-success').addClass('d-none');
        $('#alert-error').addClass('d-none');
    }, 5000); 
}