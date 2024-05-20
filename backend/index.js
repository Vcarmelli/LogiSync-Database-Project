$(document).ready(function() {
    $('#toggle-btn').click(menu);
});

function menu() {
    $('#sidebar').toggleClass('expand');
}