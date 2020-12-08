$(document).ready(function () {
    var selItem = null
    var insert = true
    $('#back').on('click', function () {
        document.location.href = $('#grid').data('backRoute')
    })
    $("#loader").jqxLoader({  width: 100, height: 60, imagePosition: 'top' })
    $('#tabNextMatch').jqxTabs({ width: '100%', position: 'top'})
    $('#tabFinishMatch').jqxTabs({ width: '100%', position: 'top'})
    var tournClosed = $('#closed').val() == 1 ? true : false
    if(!tournClosed) {
        var source = {
            datatype: "json",
            type: "GET",
            datafields: [
                { name: 'id' },
                { name: 'parent_id' },
                { name: 'levels_id' },
                { name: 'name' },
                { name: 'shortname'},
                { name: 'priority' },
            ],
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('loadStages'),
            async: false,
        }
        var dataAdapter = new $.jqx.dataAdapter(source, {
            beforeLoadComplete: function (records) {
                for(var i=0; i<records.length; i++) {
                    if(i==0) records[i]['selected'] = true
                    if(records[i]['parent_id'] === null) records[i]['parent_id'] = 0;
                    records[i]['expanded'] = true
                }
                return records;
            }
        })
        dataAdapter.dataBind()
        var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{ name: 'name', map: 'label'},{ name: 'id', map: 'value'}])
        $('#tour').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
        $('#arena').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
        $('#home').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
        $('#away').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
        $('#number').jqxNumberInput({ value: parseInt($('#max-number-match').val()) + 1, width: '100%', height: '35px', spinButtons: true, digits: 3,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 500, spinButtonsWidth: 30, textAlign: 'left', theme: 'bootstrap' })
        $("#datetime").jqxDateTimeInput({ formatString: 'dd.MM.yyyy   HH:mm', firstDayOfWeek: 1, culture: 'ru-RU',
            showTimeButton: true, width: '100%', height: '35px', value: new Date() })
        $('#nextmatch').jqxNumberInput({ value: 1, width: '100%', height: '35px', spinButtons: true, digits: 3,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 500, spinButtonsWidth: 30, textAlign: 'left', theme: 'bootstrap' })
        $("#dropDownButton").jqxDropDownButton({ width: '100%', height: 35, theme: 'bootstrap'})
        $('#level').on('select', function (event) {
            var args = event.args;
            var item = $('#level').jqxTree('getItem', args.element);
            var dropDownContent = '<div style="position: relative; margin-left: 5px; margin-top: 7px;">' + item.label + '</div>'
            $("#dropDownButton").jqxDropDownButton('setContent', dropDownContent);
            selItem = item
            //console.log(selItem)
        })
        $('#level').jqxTree({ source: records, width: '100%', height: '200px', theme: 'bootstrap'})
        popover()

        $('body').on('click', '#remove',function () {
            if(!confirm('Удалить игру' + '?')) return false
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('removeRoute'),
                data: {id: $(this).parent().attr("data-id")},
            }).done(function(response) {
                response = JSON.parse(response);
                $('#loader').jqxLoader('close')
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    $('table tbody tr[data-match-id="'+response['match']['id']+'"]').remove()

                    $("#message").html('Матч удалён!')
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                    popover()

                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('body').on('click', '#edit',function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('editviewRoute'),
                data: {id: $(this).parent().attr("data-id")},
            }).done(function(response) {
                response = JSON.parse(response);
                $('#loader').jqxLoader('close')
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    $('#ajax').html(response['text'])
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('body').on('click', '#result',function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('resultviewRoute'),
                data: {id: $(this).parent().attr("data-id")},
            }).done(function(response) {
                response = JSON.parse(response);
                $('#loader').jqxLoader('close')
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    $('#ajax').html(response['text'])
                }
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('body').on('click', '#cancel',function () {
            if(!confirm('Отменить результат игры' + '?')) return false
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('cancelresultRoute'),
                data: {id: $(this).parent().attr("data-id")},
            }).done(function(response) {
                $('#loader').jqxLoader('close')
                response = JSON.parse(response);
                if(response['status'] === 'fail') {
                    console.log(response['text'])
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    var gg = $('#tableFinish-'+response['match']['mainstage_id']+' tbody tr[data-match-id="'+response['match']['id']+'"]')
                    if(gg) {
                        gg.remove()
                        console.log(gg)
                        var table = $('#table-'+response['match']['mainstage_id']+' > tbody:last')
                        table.append("<tr><td colspan=\"7\" class=\"text-center\"><h5><strong><u>"+response['match']['tour']["shortname"]+"</u></strong></h5></td></tr>")
                        table.append('<tr class="popoverable border-top" data-match-id="'+response['match']['id']+'" data-match-status="0">\n' +
                            '                        <td class="text-center p-2 hidden-xs">'+response['match']['number']+'</td>\n' +
                            '                        <td class="text-center"><small>'+response['match']['datetime']+'</small></td>\n' +
                            '                        <td class="text-center hidden-xs"><small>'+response['match']['stage']['shortname']+'</small></td>\n' +
                            '                        <td class="text-center hidden-xs">'+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+')</td>\n' +
                            '                        <td class="text-right">'+response['match']['home']['name']+'</td>\n' +
                            '                        <td class="text-center">-</td>\n' +
                            '                        <td class="text-left">'+response['match']['away']['name']+'</td>\n' +
                            '                    </tr>')
                    }
                    $("#message").html('Результат матча отменён!')
                    $('#messageNotification').jqxNotification({ template: 'info' })
                    $("#messageNotification").jqxNotification("open")
                    popover()
                }
            }).fail(function(response, textStatus, errorThrown) {
                $('#loader').jqxLoader('close')
                console.log('fail' + response)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('body').on('click', '#protocol',function () {
            document.location.href = "/home/tournament/match/"+$(this).parent().attr("data-id")
        })

        $('#save_button').on('click', function () {
            // сохранить
            var vyb = false
            for (var i =0; i<dataAdapter.records.length; i++) {
                if(dataAdapter.records[i]['id'] == selItem.value && dataAdapter.records[i]['levels_id'] == 5) {
                    vyb = true
                    break
                }
            }
            if(selItem.hasItems && !vyb) {
                $("#message").html('Необходимо выбрать конечный этап соревнований')
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
                return false
            }
            if(vyb && !selItem.parentElement) {
                $("#message").html('Необходимо выбрать стадию')
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
                return false
            }
            if($('#arena').val() == 0) {
                $("#message").html('Необходимо выбрать арену, на котором матч будет проходить')
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
                return false
            }

            var attr = {
                "id":      $('#tournament-id').val(),
                "stage":   selItem.value,
                "number":  $('#number').val(),
                "datetime":$('#datetime').val(),
                "tour":    $('#tour').val(),
                "arena":   $('#arena').val(),
                "home":    $('#home').val(),
                "away":    $('#away').val(),
            }
            if(insert) {
                // если вставка
                $('#loader').jqxLoader('open')
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $('#grid').data('saveRoute'),
                    data: attr,
                }).done(function(response) {
                    $('#loader').jqxLoader('close')
                    response = JSON.parse(response);

                    if(response['status'] === 'fail') {
                        console.log(response['text'])
                        $("#message").html('Ошибка. ' + response['text'])
                        $('#messageNotification').jqxNotification({ template: 'error' })
                        $("#messageNotification").jqxNotification("open")
                    } else {
                        console.log(response['match'])
                        var dt = $('#datetime').jqxDateTimeInput('getDate')
                        dt = new Date(dt.getTime() + 60000 * $('#nextmatch').val())
                        $('#datetime ').jqxDateTimeInput('setDate', dt)
                        $('#number').val($('#number').val() + 1)

                        var table = $('#table-'+response['match']['mainstage_id']+' > tbody:last')
                        table.append("<tr><td colspan=\"7\" class=\"text-center\"><h5><strong><u>"+response['match']['tour']["shortname"]+"</u></strong></h5></td></tr>")
                        if(response['match']['away'] && response['match']['home'])
                            table.append("<tr data-match-id=\""+response['match']['id']+"\" data-match-status=\""+response['match']['status_id']+"\" class=\"popoverable border-top\"><td class=\"text-center p-2 hidden-xs\">"+response['match']['number']+"</td><td class=\"text-center\"><small>"+response['match']['datetime']+"</small></td><td class=\"text-center\"><small></small></td><td class=\"text-center hidden-xs\">"+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+")</td><td class=\"text-right\">"+response['match']['home']['name']+"</td><td class=\"text-center\">-</td><td class=\"text-left\">"+response['match']['away']['name']+"</td></tr>")
                        else if(response['match']['home']) table.append("<tr data-match-id=\""+response['match']['id']+"\" data-match-status=\""+response['match']['status_id']+"\" class=\"popoverable border-top\"><td class=\"text-center p-2 hidden-xs\">"+response['match']['number']+"</td><td class=\"text-center\"><small>"+response['match']['datetime']+"</small></td><td class=\"text-center\"><small></small></td><td class=\"text-center hidden-xs\">"+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+")</td><td class=\"text-right\">"+response['match']['home']['name']+"</td><td class=\"text-center\">-</td><td class=\"text-left\"><small class='red'>нет</small> </td></tr>")
                        else if(response['match']['away']) table.append("<tr data-match-id=\""+response['match']['id']+"\" data-match-status=\""+response['match']['status_id']+"\" class=\"popoverable border-top\"><td class=\"text-center p-2 hidden-xs\">"+response['match']['number']+"</td><td class=\"text-center\"><small>"+response['match']['datetime']+"</small></td><td class=\"text-center\"><small></small></td><td class=\"text-center hidden-xs\">"+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+")</td><td class=\"text-right\"><small class='red'>нет</small></td><td class=\"text-center\">-</td><td data-match-id=\"'+response['match']['id']+'\" class=\"text-left\">"+response['match']['away']['name']+"</td></tr>")
                        else table.append("<tr data-match-id=\""+response['match']['id']+"\" data-match-status=\""+response['match']['status_id']+"\" class=\"popoverable border-top\"><td class=\"text-center p-2 hidden-xs\">"+response['match']['number']+"</td><td class=\"text-center\"><small>"+response['match']['datetime']+"</small></td><td class=\"text-center\"><small></small></td><td class=\"text-center hidden-xs\">"+response['match']['place']['field']['arena']['name']+" ("+response['match']['place']['field']['number']+")</td><td class=\"text-right\"><small class='red'>нет</small></td><td class=\"text-center\">-</td><td class=\"text-left\"><small class='red'>нет</small></td></tr>")

                        $("#message").html('Матч добавлен!')
                        $('#messageNotification').jqxNotification({ template: 'info' })
                        $("#messageNotification").jqxNotification("open")
                        popover()
                    }
                }).fail(function(response, textStatus, errorThrown) {
                    $('#loader').jqxLoader('close')
                    console.log('fail' + response)
                    $("#message").html('Ошибка. ' + errorThrown)
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                })
            }
        })
    } // от закрытого турнира
})

function popover() {
    if($('.popoverable').length == 0) return false
    $('.popoverable').jqxTooltip({ content: '', position: 'mouse', name: 'movieTooltip', autoHideDelay: 10000, theme: 'bootstrap', trigger: 'click'})
    $('.popoverable').bind('opening',function () {
        //console.log($(this).attr('data-match-status'))
        var cont = '';
        if($(this).attr('data-match-status') == 0) {
            if($(this).attr('data-match-completed') == 1) {
                cont = cont + '<i id="result" title="Результат матча" class="fa fa-check remove p-2"></i>';
                cont = cont + '<i id="protocol" title="Протокол матча" class="fa fa-book remove p-2"></i>';
            }
            cont = cont + '<i title="Арбитр матча" class="fa fa-male remove p-2"></i><i title="Изменить матч" class="fa fa-edit remove p-2" id="edit"></i><i class="fa fa-close remove p-2" id="remove" title="Удаление матча"></i>';
        }
        else if($(this).attr('data-match-status') == 1) cont = cont + '<i id="result" title="Результат матча" class="fa fa-check remove p-2"></i><i id="protocol" title="Протокол матча" class="fa fa-book remove p-2"></i><i title="Арбитр матча" class="fa fa-male remove p-2"></i>';
        else if($(this).attr('data-match-status') == 2) cont = cont + '<i id="cancel" title="Отмена результата матча" class="fa fa-history remove p-2"></i><i id="protocol" title="Протокол матча" class="fa fa-book remove p-2"></i>';
        $(this).jqxTooltip({ content: '<div data-id="'+$(this).attr("data-match-id")+'">'+cont+'</div>'})
    })
}
