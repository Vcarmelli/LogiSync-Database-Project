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
                $('#pagination-nav').addClass('d-none');
                $('#unav-btn').addClass('d-none');
                $('.default-table').hide();

                $('#view-btn').removeClass('d-none');
                $('#view-btn').removeClass('active');
                $('#results').show();
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

