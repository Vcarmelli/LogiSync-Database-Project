$(document).ready(function() {
    $('#query').on('submit', querySupplier);
}); 

function querySupplier(event) {
    event.preventDefault();

    var supplierID = $('#supplier_id').val();
    console.log('supplier_id:', supplierID);

    var data = {
        getProducts: true,
        supplierID: supplierID
    }

    $.ajax({
        type: 'POST',
        url: '../includes/retrieve.php',
        data: data,
        success: function(response) {
            //alert('Supplier product retrieved successfully!');
            console.log("list:", response);
            $('#result').html(response);
            //$('#query')[0].reset();
        },
        error: function(error) {
            alert('Error retrieving supplier products');
        }
    });
}