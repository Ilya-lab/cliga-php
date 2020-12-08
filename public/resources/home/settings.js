/*
 * Copyright (c) Корпоративная лига 2020
 */

$(document).ready(function () {
    $('#back').on('click', function () {
        document.location.href = $('#grid').data('backRoute')
    })
    $("#loader").jqxLoader({  width: 100, height: 60, imagePosition: 'top' })
})
