// FOR INTERFACE

$(document).ready(function() {
    console.log("INDEX LOADED");
    $('#toggle-btn').click(menu);
    $('button[data-bs-toggle="modal"]').on('click', addData);

    $('.edit').on('click', editData);
    $('.delete').on('click', deleteData);
});


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
    console.log("EDIT BUTTON CLICKED");

    switch(formType) {
        case 'supplierTable':
            formUrl = '../pages/edit.php?form=supplier';
            break;
        case 'productTable':
            formUrl = '../pages/edit.php?form=product';
            break;
        case 'orderTable':
            formUrl = '../pages/edit.php?form=purchaseorder';
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
    console.log("EDIT BUTTON CLICKED");

    switch(formType) {
        case 'supplierTable':
            formUrl = '../pages/edit.php?form=supplier';
            break;
        case 'productTable':
            formUrl = '../pages/edit.php?form=product';
            break;
        case 'orderTable':
            formUrl = '../pages/edit.php?form=purchaseorder';
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

function menu() {
    $('#sidebar').toggleClass('expand');
}