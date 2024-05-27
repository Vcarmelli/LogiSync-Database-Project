// FOR INTERFACE

$(document).ready(function() {
    console.log("INDEX LOADED");
    $('#toggle-btn').click(menu);
    $('button[data-bs-toggle="modal"]').on('click', addData);

    $('.edit').on('click', editData);
    $('.delete').on('click', deleteData);
    //$('.stock').on('click', deleteData);
    $('.print').on('click', printInvoice);
});

function menu() {
    $('#sidebar').toggleClass('expand');
    $('#right-charts').toggleClass('shorten');
    $('#left-charts').toggleClass('shorten');
}

function addData() {
    var formType = $(this).data('form');
    var formUrl = '';
    console.log("ADD BUTTON CLICKED");

    switch(formType) {
        case 'supplier':
            formUrl = '../pages/forms.php?form=supplier';
            break;
        case 'product':
            formUrl = '../pages/forms.php?form=product';
            break;
        case 'purchaseorder':
            formUrl = '../pages/forms.php?form=purchaseorder';
            break;
        default:
            formUrl = '';
    }
    
    console.log('ADD Form URL:', formUrl);
    if (formUrl) {
        $.ajax({
            url: formUrl,
            method: 'GET',
            success: function(response) {
                $('#modalContent').html(response);
                formSubmissionHandlers();
            },
            error: function() {
                console.error('Error:', error);
                $('#modalContent').html('<p class="text-danger">An error occurred while loading the form.</p>');
            }
        });
    }
}


function editData() {
    var formType = $(this).closest('table').attr('id');
    var rowID = $(this).closest('tr').find('.rowID').val();
    var formUrl = '';
    console.log("EDIT BUTTON CLICKED", formType);
    console.log("rowID:", rowID);


    switch(formType) {
        case 'supplierTable':
            formUrl = '../pages/edit.php?form=supplier&id=' + rowID;
            break;
        case 'productTable':
            formUrl = '../pages/edit.php?form=product&id=' + rowID;
            break;
        case 'orderTable':
            formUrl = '../pages/edit.php?form=purchaseorder&id=' + rowID;
            break;
        default:
            formUrl = '';
    }
    
    console.log('EDIT Form URL:', formUrl);
    if (formUrl) {
        $.ajax({
            url: formUrl,
            method: 'GET',
            success: function(response) {
                $('#editModalContent').html(response);
                formModificationHandlers(rowID);
            },
            error: function() {
                console.error('Error:', error);
                $('#editModalContent').html('<p class="text-danger">An error occurred while loading the form.</p>');
            }
        });
    }
}

function deleteData() {
    var formType = $(this).closest('table').attr('id');
    var rowID = $(this).closest('tr').find('.rowID').val();
    var formUrl = '';
    console.log("DELETE BUTTON CLICKED");
    console.log("rowID:", rowID);
    console.log("formType:", formType);

    switch(formType) {
        case 'supplierTable':
            formUrl = '../pages/delete.php?form=supplier&col=SupplierID&id=' + rowID;
            break;
        case 'productTable':
            formUrl = '../pages/delete.php?form=product&col=ProductID&id=' + rowID;
            break;
        case 'orderTable':
            formUrl = '../pages/delete.php?form=purchaseorder&col=OrderID&id=' + rowID;
            break;
        default:
            formUrl = '';
    }
    
    console.log('DELETE Form URL:', formUrl);
    if (formUrl) {
        $.ajax({
            url: formUrl,
            method: 'GET',
            success: function(response) {
                $('#deleteModalContent').html(response);
                formModificationHandlers(rowID);
            },
            error: function() {
                console.error('Error:', error);
                $('#deleteModalContent').html('<p class="text-danger">An error occurred while loading the form.</p>');
            }
        });
    }
}


function printInvoice() {
    var formType = $(this).closest('table').attr('id');
    var rowID = $(this).closest('tr').find('.rowID').val();
    var formUrl = '';

    console.log("PRINT rowID:", rowID);

    switch(formType) {
        case 'supplierTable':
            formUrl = '../includes/print.php?id=' + rowID;
            break;
        case 'productTable':
            formUrl = '../includes/print.php?id=' + rowID;
            break;
        case 'orderTable':
            formUrl = '../includes/print.php?id=' + rowID;
            break;
        default:
            formUrl = '';
    }

    if (formUrl) {
        $.ajax({
            url: formUrl,
            method: 'GET',
            data: {print: true},
            success: function(response) {
                console.log("Printer Response:", response);
            },
            error: function() {
                console.error('Error:', error);
            }
        });
    }
}