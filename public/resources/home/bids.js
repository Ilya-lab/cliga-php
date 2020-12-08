function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function formDisabled(dis) {
    $('#bidname').prop('disabled', dis);
    $('#start').prop('disabled', dis);
    $('#finish').prop('disabled', dis);
    $('#teams').prop('disabled', dis);
    $('#referees').prop('disabled', dis);
    $('#admins').prop('disabled', dis);
    $('#arenas').prop('disabled', dis);
    $('#players').prop('disabled', dis);
    if(dis) {
        $('#loader').removeClass('hidden');
    } else {
        $('#loader').addClass('hidden');
    }
}
function formClear() {
    $('#bidname').val('');
    $('#start').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        date: new Date(),
    });
    var d = new Date()
    d.setDate(d.getDate() + 3)
    $('#finish').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        date: d,
    });
}
$(function () {
    $('#start').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        date: new Date(),
    });
    var d = new Date()
    d.setDate(d.getDate() + 3)
    $('#finish').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY',
        date: new Date(d),
    });
});

$(document).ready(function () {
    var edit = false;
    var source = {
        datatype: "json",
        type: "GET",
        datafields: [
            { name: 'id' },
            { name: 'name' },
            { name: 'start'},
            { name: 'finish' },
            { name: 'is_team' },
            { name: 'is_coach' },
            { name: 'is_arena' },
            { name: 'is_referee' },
            { name: 'is_player' },
        ],
        id: "id",
        url: $('#grid').data('loadRoute'),
        async: true,
    };
    var dataAdapter = new $.jqx.dataAdapter(source, {
        loadError: function (jqXHR, status, error) {
            console.log(error)
            $("#message").html('Ошибка. ' + error);
            $("#messageNotification").jqxNotification("open");
        }
    });

    $("#messageNotification").jqxNotification({
        position: "top-right", opacity: 0.8,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 10000, template: "error"
    });
    $('#formVal').jqxValidator({
        rules: [
            { input: '#bidname', message: 'Введите наименование заявочного окна', action: 'keyup, blur', rule: 'required' },
            { input: '#start', message: 'Введите дату открытия окна', action: 'keyup, blur', rule: 'required' },
            { input: '#finish', message: 'Введите дату закрытия окна', action: 'keyup, blur', rule: 'required' },
        ]
    });

    $('#save').on('click', function () {
        $('#formVal').jqxValidator('validate');
    });

    $('#formVal').on('validationSuccess', function (event) {
        formDisabled(true);
        var attr = {
            "id":      $('#bid-id').val(),
            "tournament_id": $('#tournament-id').val(),
            "bidname": $('#bidname').val(),
            "start":$('#start').val(),
            "finish":$('#finish').val(),
            "teams":  $('#teams').prop('checked'),
            "arenas":  $('#arenas').prop('checked'),
            "admins":  $('#admins').prop('checked'),
            "referees":  $('#referees').prop('checked'),
            "players":  $('#players').prop('checked'),
        }
        if (edit === false) {
            // если новая запись
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('saveRoute'),
                data: attr,
            }).done(function(response) {
                response = JSON.parse(response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $('#dialog').modal('toggle');
                formClear();
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text']);
                    $('#messageNotification').jqxNotification({ template: 'error' });
                    $("#messageNotification").jqxNotification("open");
                } else {
                    $("#message").html('Заявка добавлена!');
                    $('#messageNotification').jqxNotification({ template: 'info' });
                    $("#messageNotification").jqxNotification("open");
                    dataAdapter.dataBind();
                }
            }).fail(function(response, textStatus, errorThrown) {
                $('#dialog').modal('toggle');
                console.log('fail' + response);
                formDisabled(false);
                $('#loader').addClass('hidden');
                $("#message").html('Ошибка. ' + errorThrown);
                $('#messageNotification').jqxNotification({ template: 'error' });
                $("#messageNotification").jqxNotification("open");
            });
        }
    });
    $('#dialog').on('hide.bs.modal', function () {
        $('#formVal').jqxValidator('hide');
        formClear()
        formDisabled(false)
        edit = false
    });

    $("#grid").jqxGrid(
    {
        width: '100%',
        theme: 'bootstrap',
        source: dataAdapter,
        columnsresize: true,
        adaptive: true,
        localization: 'ru-RU',
        columns: [
            { text: 'Наименование заявки', datafield: 'name', align: 'center' },
            { text: 'Дата начала', datafield: 'start', width: 120, align: 'center', cellsalign: 'center',
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    if(value.length == 0) return '';
                    var dd = new Date(value);
                    var col = "black";
                    /*if(birth[0] <= 16) col = "red";
                    else if(birth[0] > 40) col = "orange";*/
                    return '<div class="jqx-grid-cell-middle-align" style="margin-top: 8.5px; color: '+col+'">' + dd.toLocaleDateString() + '</div>';
                }
            },
            { text: 'Дата окончания', datafield: 'finish', width: 120, align: 'center', cellsalign: 'center',
                cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                    if(value.length == 0) return '';
                    var dd = new Date(value);
                    var col = "black";
                    /*if(birth[0] <= 16) col = "red";
                    else if(birth[0] > 40) col = "orange";*/
                    return '<div class="jqx-grid-cell-middle-align" style="margin-top: 8.5px; color: '+col+'">' + dd.toLocaleDateString() + '</div>';
                }
            },
            { text: 'Игроки', datafield: 'is_player', width: 100, align: 'center',  columntype: 'checkbox' },
            { text: 'Штаб команды', datafield: 'is_coach', width: 100, align: 'center',  columntype: 'checkbox' },
            { text: 'Судьи', datafield: 'is_referee', width: 100, align: 'center',  columntype: 'checkbox' },
            { text: 'Стадионы', datafield: 'is_arena', width: 100, align: 'center',  columntype: 'checkbox' },
            { text: 'Команды', datafield: 'is_team', width: 100, align: 'center',  columntype: 'checkbox' },
        ]
    });
    $('#back').on('click', function () {
        document.location.href = $('#grid').data('backRoute');
    });
});
