// FOR DATABASE MANIPULATION

function formSubmissionHandlers() {
    console.log("SCRIPT LOADED");
    $('#addSupplierForm').on('submit', addRow);
    $('#addProductForm').on('submit', addRow);
    $('#addOrderForm').on('submit', addRow);
}; 

function formModificationHandlers(rowID) {
    console.log("MODIFY TABLE");
    
    $('#updateSupplierForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });
    $('#updateProductForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });
    $('#updateOrderForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });

    $('#deleteForm').on('submit', function(event) { deleteRow(event, rowID, $(this).closest('form')); });
}

function addRow(event) {
    event.preventDefault();
    var form = $(this).closest('form');
    var table = form.attr('id');

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
            console.log('response:', response);
            triggerAlert(response, table);
            form[0].reset();
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });

};


function editRow(event, rowID, form) {
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
            console.log('table:', table);
            triggerAlert(response, table);
            form[0].reset();
        },
        error: function(error) {
            console.error("Error:", error);
            alert('Error editing', table);
        }
    });
}


function deleteRow(event, rowID, form) {
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
            console.log('table:', table);
            triggerAlert(response, table);
            form[0].reset();
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
    } else if(table === "purchaseorder") {
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


function triggerAlert(response, table) {
    console.log("response:", response);
    if(response === 'true') {
        $('#alert-success').removeClass('d-none').fadeTo(2000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        $('#alert-error').addClass('d-none');
    } else {
        $('#alert-error').html(response.message);
        $('#alert-error').removeClass('d-none').fadeTo(2000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        $('#alert-success').addClass('d-none');
    }
    closeModal(table);
}

function closeModal(table) {
    switch (table) {
        case 'addSupplierForm':
        case 'addProductForm':
        case 'addOrderForm':
            $('#dynamicFormModal').modal('hide');
            break;
        case 'supplier':
        case 'product':
        case 'purchaseorder':
            $('#dynamicEditModal').modal('hide');
            break;
        default:
            break;
    }
}
