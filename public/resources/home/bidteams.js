$(document).ready(function () {
    $('#back').on('click', function () {
        document.location.href = $('#grid').data('backRoute');
    })
})
