// FOR DATABASE MANIPULATION

function formSubmissionHandlers() {
    console.log("SCRIPT LOADED");
    $('#addSupplierForm').on('submit', addRow);
    $('#addProductForm').on('submit', addRow);
    $('#addOrderForm').on('submit', addRow);
    supplierProdsHandlers();
}

function supplierProdsHandlers() {
    $('#supplierIdPO').change(() => getProducts('add'));
    $('#supplierIdPOUD').change(() => getProducts('update'));
}

function formModificationHandlers(rowID) {
    console.log("MODIFY TABLE");
    
    $('#updateSupplierForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });
    $('#updateProductForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });
    $('#updateOrderForm').on('submit', function(event) { editRow(event, rowID, $(this).closest('form')); });

    $('#deleteForm').on('submit', function(event) { deleteRow(event, rowID, $(this).closest('form')); });
}

function getProducts(operation) {
    var supplierId = '';
    var targetElement = '';

    if (operation === 'add') {
        supplierId = $('#supplierIdPO').val();
        targetElement = '#supplierProducts';
    } else {
        supplierId = $('#supplierIdPOUD').val();
        targetElement = '#supplierProductsUD';
    } 
    
    console.log("supplierId:", supplierId);
    console.log("targetElement:", targetElement);
    $.ajax({
        type: 'GET',
        url: '../components/get_products.php',
        data: { supplierId: supplierId },
        success: function(response) {
            $(targetElement).html(response);
        },
        error: function(error) {
            console.error("Error:", error);
        }
    });
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
        dataType: 'json',
        success: function(response) {
            console.log('add row response:', response);
            if (response.success) {
                triggerAlert(response.success, table);
                form[0].reset();
            } else {
                showCRUDErrors(response.errors, "add");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr, status, error);
            alert('An error occurred: ' + xhr.responseText);
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
            console.log('edit row response:', response);
            if (response.success) {
                triggerAlert(response.success, table);
                form[0].reset();
            } else {
                showCRUDErrors(response.errors, "edit");
            }
        },
        error: function(error) {
            console.error("Error:", error);
            alert("Error in updating the data.");
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
            console.log('delete row response:', response);
            if (response.success) {
                triggerAlert(response.success, table);
                form[0].reset();
            } else {
                showCRUDErrors(response.errors, "delete");
                console.log("delete errors:", response.errors);
            }
        },
        error: function(error) {
            console.error("Error:", error);
            alert("Error in deleting the data.");
        }
    });
}

function getProductsQuantity(table) {
    var products = [];
    $('#' + table + ' .quantity').each(function() {
        var productId = $(this).attr('name');
        var quantity = $(this).val();
        products.push({ productId: productId, quantity: quantity });
    });
    console.log("quan:", products);
    return products;
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
    var quantity = getProductsQuantity("prodsQuantity");
    const data = {
        supplierIdPO: $('#supplierIdPO').val(),
        orderDate: $('#orderDate').val(),
        deliveryDate: $('#deliveryDate').val(),
        quantity: quantity
    }
    console.log("data w/ quan:", data);
    return data
}

function getProductData() {
    const data = {
        productName: $('#productName').val(),
        supplierId: $('#supplierId').val(),
        price: $('#price').val(),
        quantity: $('#quantity').val()
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
    var quantity = getProductsQuantity("prodsQuantity");
    const data = {
        supplierIdPO: $('#supplierIdPOUD').val(),
        orderDate: $('#orderDateUD').val(),
        deliveryDate: $('#deliveryDateUD').val(),
        quantity: quantity
    }
    return data
}

function getUDProductData() {
    const data = {
        productName: $('#productNameUD').val(),
        supplierId: $('#supplierIdUD').val(),
        price: $('#priceUD').val(),
        quantity: $('#quantityUD').val()
    }
    return data
}


function triggerAlert(response, table) {
    console.log("response:", response);
    if(response) {
        $('#alert-success').removeClass('d-none').fadeTo(2000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        $('#alert-error').addClass('d-none');
        closeModal(table);
    } else {
        $('#alert-error').html(response.message);
        $('#alert-error').removeClass('d-none').fadeTo(2000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
        $('#alert-success').addClass('d-none');
    }
    
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

function showCRUDErrors(errors, operation) {
    $.each(errors, function(key, value) {
        if (operation === "edit") {
            key = key + "UD";
        }

        $('#' + key).addClass('is-invalid');
        $('#' + key).siblings('.invalid-feedback').text(value);
        console.log("key", key, "val", value);
    });
}