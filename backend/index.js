// FOR INTERFACE

$(document).ready(function() {
    console.log("INDEX LOADED");

    $('#logo-btn').click(homepage);
    $('#log-btn').click(homepage);
    $('.type-btn').click(toggleTypes);
    $('.account-btn').click(toggleLogSign);
    $('#guest-btn').click(guestDashboard);
    $('#toggle-btn').click(menu);

    $('#view-btn').click(showTable);
    $('#unav-btn').click(showUnavProds);
    $('button[data-bs-toggle="modal"]').on('click', addData);
    
    loginSubmissionHandlers();
    bindEventHandlers();
});

function homepage() {
    $('#homepage').toggleClass('login');
    $('#homepage').toggleClass('landing');
    $('#landing-main').toggleClass('d-none');
    $('#logtypes').toggleClass('d-none');
    clearLoginForm();
    clearSignupForm();
}

function toggleTypes() {
    $('#admin').toggleClass('active');
    $('#manager').toggleClass('active');
    clearLoginForm();
}

function toggleLogSign() {
    $('#logtypes').toggleClass('d-none');
    $('#landing-signup').toggleClass('d-none');
    clearLoginForm();
    clearSignupForm();
}

function menu() {
    $('#sidebar').toggleClass('expand');
    $('#right-charts').toggleClass('shorten');
    $('#left-charts').toggleClass('shorten');
}

function showTable() {
    const table = $(this).data('table');

    if (table === 'product') {
        $('#unavailableProds').addClass('d-none');
        $('#unav-btn').removeClass('d-none');
        $('#unav-btn').removeClass('active');
        $('#allProds').removeClass('d-none');   
    } else if (table === 'purchaseorder') {
        $('#byMonth').hide();
        $('#allOrders').show();
    }
    
    $('#results').hide();
    $('.default-table').show();
    $('#pagination-nav').removeClass('d-none');

    $('#view-btn').addClass('active');
    $('#search')[0].reset();
}

function showPrint() {
    console.log('Print INvoice clicked');
    window.print();
}

function showUnavProds() {
    $('#results').hide();
    $('#pagination-nav').addClass('d-none');
    $('#allProds').addClass('d-none');

    $('#unavailableProds').removeClass('d-none');
    $('#unav-btn').addClass('active');
    $('#view-btn').removeClass('active');
}

function loginSubmissionHandlers() {
    console.log("LOGIN LOADED");
    $('#signupForm').on('submit', signupUser);
    $('#loginForm').on('submit', loginUser);
};


function signupUser(event) {
    event.preventDefault();

    $('.form-control').removeClass('is-invalid');

    const signupData = {
        action: 'signup',
        username: $('#username').val(),
        password: $('#password').val(),
        repassword: $('#repassword').val(),
        email: $('#email').val()
    }
    console.log("SIGNUP DATA:", signupData);

    $.ajax({
        type: 'POST',
        url: '../includes/userentry.php',
        data: signupData,
        timeout: 15000,
        dataType: 'json',
        success: function(response) {
            console.log("res from signup:", response);
            if (response.success) {
                window.location.href = '../index.php';
                alert(response.message);
                clearSignupForm();
            } else {
                console.log("res from signup:", response.errors);
                showErrors(response.errors);
            }
        },
        error: function(error) {
            console.error("SIGNUP Error:", error.responseText);
            alert('SIGNUP Error', error.responseText);
        }
    });
};

function loginUser(event) {
    event.preventDefault();
    const accType = $('#logtypes .nav-link.active').attr('id');

    $('.form-control').removeClass('is-invalid');

    const loginData = {
        action: 'login',
        username: $('#usernameLI').val(),
        password: $('#passwordLI').val()
    }
    console.log("LOGIN DATA:", loginData);

    $.ajax({
        type: 'POST',
        url: '../includes/userentry.php',
        data: loginData,
        timeout: 15000,
        dataType: 'json',
        success: function(response) {
            console.log("res from signup:", response);
            if (response.success) {
                window.location.href = `../pages/dashboard.php?view=${accType}`;
                clearLoginForm();
            } else {
                console.log("res from login:", response.errors);
                showErrors(response.errors);
            }
        },
        error: function(error) {
            console.error('LOGIN Error:', error.responseText);
            alert("Cannot log in user.");
        }
    });
};

function guestDashboard() {
    $.get('./pages/dashboard.php', { view: 'guest' })
        .done(function(data) {
            window.location.href = './pages/dashboard.php';
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
        });
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
                supplierProdsHandlers();
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
                supplierProdsHandlers();
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
    var rowID = $(this).closest('tr').find('.rowID').val();

    console.log("PRINT rowID:", rowID);
    var formUrl = '../includes/print.php?id=' + rowID;

    console.log('PRINT Form URL:', formUrl);
    if (formUrl) {
        $.ajax({
            url: formUrl,
            method: 'GET',
            success: function(response) {
                $('#printModalContent').html(response);
                $('.print-btn').on('click', showPrint);
                
            },
            error: function() {
                console.error('Error:', error);
            }
        });
    }
}

function clearSignupForm() {
    $('#signupForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
}

function clearLoginForm() {
    $('#loginForm')[0].reset();
    $('.form-control').removeClass('is-invalid');
}


function showErrors(errors) {
    $.each(errors, function(key, value) {
        if (key === 'query') {
            console.log("Query Error:", val);
        } else {
            $('#' + key).addClass('is-invalid');
            $('#' + key).siblings('.invalid-feedback').text(value);
        }
    });
}