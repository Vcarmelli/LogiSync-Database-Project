// FOR QUERYING PURPOSES

$(document).ready(function() {
    $('#search').on('submit', querySearch);
    $('.dropdown-item').on('click', getOrderByMonth);
    
    bindEventHandlers();
}); 

function bindEventHandlers() {
    $('.edit').on('click', editData);
    $('.delete').on('click', deleteData);
    $('.print').on('click', printInvoice);
    $('.page-link').on('click', loadPage); // Ensure pagination links are bound
}

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
        action: 'search',
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
                bindEventHandlers();
            }
        },
        error: function(error) {
            alert('Error searching query!');
        }
    });
}

function loadPage() {
    var page = $(this).data('page');
    var table = $(this).data('table');
    console.log("page:", page);
    console.log("table:", table);

    $('.page-item').removeClass('active');
    $('.page-link[data-page="' + page + '"]').closest('.page-item').addClass('active');

    const data  = {
        page: page,
        table: table
    }

    $.ajax({
        url: '../components/get_all.php', 
        type: 'GET',
        data: data,
        success: function(response) {
            $('.load-all').html(response);
            bindEventHandlers();
        },
        error: function(xhr, status, error) {
            console.error('PAGE Error: ' + status + error);
        }
    });
}

function getOrderByMonth() {
    var month = $(this).data('month');
    console.log("month selected:", month);

    const data  = {
        action: 'orderbymonth',
        month: month,
    }

    $.ajax({
        url: '../components/get_bymonth.php', 
        type: 'GET',
        data: data,
        success: function(response) {
            //console.log(response);
            $('#pagination-nav').addClass('d-none');
            $('#view-btn').removeClass('active');
            $('#allOrders').hide();
            $('#results').hide();
            $('.default-table').show();
            $('#byMonth').show();
            $('#byMonth').html(response);
            $('#search')[0].reset();
            bindEventHandlers();
        },
        error: function(xhr, status, error) {
            console.error('PAGE Error: ' + status + error);
        }
    });
}