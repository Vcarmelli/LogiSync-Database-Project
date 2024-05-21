// FOR INTERFACE

$(document).ready(function() {
    $('#toggle-btn').click(menu);
});

function menu() {
    $('#sidebar').toggleClass('expand');
}

$(document).ready(function() {
    // Handle button clicks and load the appropriate form into the modal
    
    $('button[data-bs-toggle="modal"]').on('click', function() {
        var formType = $(this).data('form');
        var formUrl = '';
        console.log("BUTTON CLICKED");

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
        
        console.log('Form URL:', formUrl);
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
    });
});