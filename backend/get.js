// $(document).ready(function() {
//     $('#query').on('submit', querySupplier);
// }); 

// function querySupplier(event) {
//     event.preventDefault();

//     var supplierID = $('#supplier_id').val();
//     console.log('supplier_id:', supplierID);

//     var data = {
//         getProducts: true,
//         supplierID: supplierID
//     }

//     $.ajax({
//         type: 'POST',
//         url: '../includes/retrieve.php',
//         data: data,
//         success: function(response) {
//             //alert('Supplier product retrieved successfully!');
//             console.log("list:", response);
//             $('#result').html(response);
//             //$('#query')[0].reset();
//         },
//         error: function(error) {
//             alert('Error retrieving supplier products');
//         }
//     });
// }


// FOR QUERYING PURPOSES

$(document).ready(function() {
    $('#search').on('submit', querySearch);
}); 


function querySearch(event) {
    event.preventDefault();

    const tableColumns = {
        'supplier': ['SupplierID', 'SupplierName'],
        'product': ['ProductID', 'ProductName', 'SupplierID'],
        'purchaseorder': ['OrderID', 'SupplierID']
    };

    const searchInput = $('.search-input').val();
    const searchTable = $('.search-table').val();
    const searchColumns = tableColumns[searchTable];

    console.log('searchInput:', searchInput);
    console.log('searchTable:', searchTable);
    console.log('Columns to be checked:', searchColumns);

    const data = {
        querySearch: true,
        searchInput: searchInput,
        searchTable: searchTable,
        searchColumns: searchColumns
    }

    $.ajax({
        type: 'GET',
        url: '../includes/search.php',
        data: data,
        success: function(response) {
            if (response === null){
                $('#results').html("No matching records found");
            } else {
                $('.default-table').hide();
                $('#results').html(response);
                $('.edit').on('click', editData);
                $('.delete').on('click', deleteData);
                $('.print').on('click', printInvoice);
            }
        },
        error: function(error) {
            alert('Error searching query!');
        }
    });
}

