// FOR INTERFACE

$(document).ready(function() {
    console.log("INDEX LOADED");

    $('#logo-btn').click(homepage);
    $('#signup-btn').click(showSignup);
    $('#admin-btn').click(showSignup);
    $('#log-btn').click(homepage);
    $('#guest-btn').click(guestDashboard);
    $('#toggle-btn').click(menu);
    
    $('button[data-bs-toggle="modal"]').on('click', addData);
    $('.edit').on('click', editData);
    $('.delete').on('click', deleteData);
    //$('.stock').on('click', deleteData);
    $('.print').on('click', printInvoice);

    loginSubmissionHandlers();
});


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

    const data = {
        action: 'login',
        username: $('#usernameLI').val(),
        password: $('#passwordLI').val()
    }
    console.log("LOGIN DATA:", data);

    $.post('../includes/userentry.php', data)
        .done(function(response) {
            if (response.success) {
                view = 'admin';
                window.location.href = `../pages/dashboard.php?view=${view}`;
            } else {
                console.log("res from login:", response.errors);
                showErrors(response.errors);
            }

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error('LOGIN Error:', textStatus, errorThrown);
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

function homepage() {
    $('#homepage').toggleClass('login');
    $('#homepage').toggleClass('landing');
    $('#landing-main').toggleClass('d-none');
    $('#landing-login').toggleClass('d-none');
}

function showSignup() {
    $('#landing-login').toggleClass('d-none');
    $('#landing-signup').toggleClass('d-none');
}

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
            data: {action: 'print'},
            success: function(response) {
                console.log("Printer Response:", response);
            },
            error: function() {
                console.error('Error:', error);
            }
        });
    }
}

function showErrors(errors) {
    $.each(errors, function(key, value) {
        $('#' + key).addClass('is-invalid');
        $('#' + key).siblings('.invalid-feedback').text(value);
        console.log("key", key, "val", value);
    });
}