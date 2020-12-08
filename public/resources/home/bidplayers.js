
$(document).ready(function () {
    var searchStr = ''
    var tournOpen = $('#tourn_status').val() <= 1 ? true : false

    $('#back').on('click', function () {
        document.location.href = $('#grid').data('backRoute');
    });
    if(!tournOpen) return false
    $('#number').jqxNumberInput({ disabled: true, value: 0, width: '100%', height: '35px', spinButtons: true, digits: 8,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 99, spinButtonsWidth: 30, textAlign: 'left',
        placeHolder: 'Введите номер в команде', allowNull: false, theme: 'bootstrap' });
    $('#position').jqxDropDownList({ disabled: true, autoDropDownHeight: true, width: '100%', height: '35px',
        theme: 'bootstrap', selectedIndex: 2});
    $('#typebid').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px',
        theme: 'bootstrap', selectedIndex: $('#_typebid').val()});
    $('#typebid').on('change', function (event)
    {
        var args = event.args;
        if (args) {
            var index = args.index;
            if(index == 0) {
                $('#dol_text').addClass('hidden');
                $('#dol').addClass('hidden');
                $('#position_text').removeClass('hidden');
                $('#position').removeClass('hidden');
                $('#number_text').removeClass('hidden');
                $('#number').removeClass('hidden');
                $('#captain_text').removeClass('hidden');
                $('#captain').removeClass('hidden');
            } else {
                $('#dol_text').removeClass('hidden');
                $('#dol').removeClass('hidden');
                $('#position_text').addClass('hidden');
                $('#position').addClass('hidden');
                $('#number_text').addClass('hidden');
                $('#number').addClass('hidden');
                $('#captain_text').addClass('hidden');
                $('#captain').addClass('hidden');
            }
            $("#player").jqxComboBox('focus');
        }
    });
    $('#dol').jqxDropDownList({ disabled: true, autoDropDownHeight: true, width: '100%', height: '35px',
        theme: 'bootstrap', selectedIndex: 5});
    $('#captain').jqxDropDownList({ disabled: true, autoDropDownHeight: true, width: '100%', height: '35px',
        theme: 'bootstrap', selectedIndex: 0});
    $('#photo').jqxDropDownList({ autoDropDownHeight: true, itemHeight: 104, height: 104, width: '100%',
        dropDownWidth: 200, disabled: true, theme: 'bootstrap',
        renderer: function (index, label, value) {
            var imgurl = $('#grid').data('path')+label;
            var img = '<img height="100" src="' + imgurl + '"/>';
            var table = '<table style="min-width: 150px;"><tr><td>' + img + '</td></tr></table>';
            return table;
        },
        selectionRenderer: function (index, label, value) {
            var imgurl = $('#grid').data('path')+value;
            var img = '<img height="100" src="' + imgurl + '"/>';
            var table = '<table style="min-width: 150px;"><tr><td style="padding: 2px;width: 50%;">' + img + '</td></tr></table>';
            return table;
        }
    });

    if ($(document).width() < 800) {
        $('#photo').jqxDropDownList({ dropDownVerticalAlignment: 'top'});
    }

    var source = {
        datatype: "json",
        type: "GET",
        datafields: [
            { name: 'id' },
            { name: 'family' },
            { name: 'name'},
            { name: 'surname' },
            { name: 'fio' },
            { name: 'birthdate' },
            { name: 'sex_id' },
            { name: 'photos' }
        ],
        id: "id",
        url: $('#grid').data('loadRoute'),
        async: true,
    };
    var dataAdapter = new $.jqx.dataAdapter(source,
    {
        formatData: function (data) {
            if ($("#players").jqxComboBox('searchString') != undefined) {
                data.person = $("#players").jqxComboBox('searchString');
                data._token = $("meta[name=csrf-token]").attr("content");
                return data;
            }
        },
        loadComplete: function (data) {
            //console.log(data.length)
            if(data.length === 0 && searchStr.length > 3) {
                $('#message').html('Нет игрока, <a href="/">добавить нового</a>?')
                $('#messageNotification').jqxNotification('open');
            }
        }
    }
    );
    function declOfNum(number, titles) {
        cases = [2, 0, 1, 1, 1, 2];
        return number+" "+titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
    }
    function birthDateToAge(b, n) {
        var x = new Date(n), z = new Date(b), b = new Date(b), n = new Date(n);
        x.setFullYear(n.getFullYear() - b.getFullYear(), n.getMonth() - b.getMonth(), n.getDate() - b.getDate());
        z.setFullYear(b.getFullYear() + x.getFullYear(), b.getMonth() + x.getMonth() + 1);
        if (z.getTime() == n.getTime()) {
            if (x.getMonth() == 11) {
                return [x.getFullYear() + 1, 0, 0];
            } else {
                return [x.getFullYear(), x.getMonth() + 1, 0];
            }
        } else {
            return [x.getFullYear(), x.getMonth(), x.getDate()];
        }
    }
    $("#players").jqxComboBox(
    {
        width: "100%",
        height: 35,
        source: dataAdapter,
        placeHolder: "Введите Фамилию Имя Отчество игрока",
        remoteAutoComplete: true,
        //autoDropDownHeight: true,
        selectedIndex: 0,
        displayMember: "fio",
        valueMember: "id",
        theme: 'bootstrap',
        renderer: function (index, label, value) {
            var item = dataAdapter.records[index];
            if (item != null) {

                var dd = new Date(item.birthdate);
                var birth = birthDateToAge(dd, new Date());
                var col = "green";
                if(birth[0] >= 80) return "<table width='100%'><tr><td align='left'>"+item.fio + "</td><td align='right'><small style='color: red;'>нет данных</small></td></tr></table>";
                if(birth[0] <= 16) col = "red";
                else if(birth[0] > 40) col = "orange";
                var label = "<table width='100%'><tr><td align='left'>"+item.fio + "</td><td align='right'><small style='color: " + col + "'>" + declOfNum(birth[0], ['год', 'года', 'лет']) + " ("+ dd.toLocaleDateString() +")</small></td></tr></table>";
                return label;
            }
            return "";
        },
        renderSelectedItem: function(index, item)
        {
            var item = dataAdapter.records[index];
            if (item != null) {
                var label = item.fio;
                return label;
            }
            return "";
        },
        search: function (searchString) {
            if (searchString.length >= 2) {
                searchStr = searchString;
                $("#player").attr("value","0");
                $("#photo_id").attr("value","0");
                $("#choice").html("<span class='red'>участник не выбран</span>");
                //$("#position").jqxDropDownList({ disabled: true });
                $("#number").jqxNumberInput({ disabled: true });
                $("#photo").jqxDropDownList({ disabled: true });
                $("#save_button").prop('disabled', true );
                $("#photo_button").prop('disabled', true );
                $("#photo").jqxDropDownList('clear');
                $("#photo").jqxDropDownList('addItem', { label: '/storage/images/no_image.png', value: 0 } );
                //$("#photo").jqxDropDownList('selectIndex', 0 );
                $("#position").jqxDropDownList('selectIndex', 2 );
                $("#dol").jqxDropDownList('selectIndex', 5 );
                $("#captain").jqxDropDownList('selectIndex', 0 );
                dataAdapter.dataBind();
            }
        }
    });

    $('#players').on('select', function (event)
    {
        var args = event.args;
        if (args) {
            $("#player").attr("value",dataAdapter.records[args.index].id);
            $("#choice").html("<span class='green'><strong>выбран: "+dataAdapter.records[args.index].fio + "</strong></span>");
            $("#position").jqxDropDownList({ disabled: false });
            $("#dol").jqxDropDownList({ disabled: false });
            $("#captain").jqxDropDownList({ disabled: false });
            $("#number").jqxNumberInput({ disabled: false });
            $("#photo").jqxDropDownList({ disabled: false });
            $("#save_button").prop('disabled', false );
            $("#photo_button").prop('disabled', false );
           // $("#position").jqxDropDownList('selectIndex', dataAdapter.records[args.index].p_position-1);
            var k=0;
            // var selItem = 0;
            dataAdapter.records[args.index].photos.forEach(function(entry) {
                $("#photo").jqxDropDownList('addItem', { label: entry.thumb[0].filename, value: entry.id} );
                k++;
            });
            $("#photo").jqxDropDownList('selectIndex', k );
        }
    });
    $('#players').on('unselect', function (event)
    {
        clearForm()
    });

    $('#photo').on('select', function (event) {
        var args = event.args;
        if (args) {
            $("#photo_id").attr("value",args.item.value);
        }
    });
    $("#messageNotification").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9, theme: 'bootstrap',
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 10000, template: "info"
    });
    $("#loader").jqxLoader({ width: 100, height: 60, imagePosition: 'top', theme: 'bootstrap' });
    $('#save_button').on('click', function () {
        $('#loader').jqxLoader('open');
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('savePlayer'),
            data: {
                "bid": $('#bid_id').val(),
                "type": $('#typebid').val(),
                "player": $('#player').val(),
                "team": $('#team_id').val(),
                "number": $('#typebid').val() == 0 ? $('#number').val() : 0,
                "position": $('#typebid').val() == 0 ? $('#position').val() : $('#dol').val(),
                "photo": $('#photo_id').val(),
                "captain": $('#typebid').val() == 0 ? $('#captain').val() : 0,
            }
        }).done(function(response) {
            $('#loader').jqxLoader('close');
             response = JSON.parse(response);

            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text']);
                $('#messageNotification').jqxNotification({ template: 'error' });
                $("#messageNotification").jqxNotification("open");
            } else {
                clearForm()

                if(response['type'] === 'player') {
                    var table = $('#table-players > tbody:last');
                    if(response['player']['captain_id'] === 0)
                        table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +'</td><td class="text-center">'+response['player']['position']['shortname']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                    else table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +' ('+response['player']['captain']['shortname']+')</td><td class="text-center">'+response['player']['position']['shortname']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                    updateTableRow('#table-players','#playercount', false)

                    table = $('#table-players-on-bid > tbody:last');
                    if(response['player']['captain_id'] === 0)
                        table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +'</td><td class="text-center">'+response['player']['position']['shortname']+'</td></tr>')
                    else table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +' ('+response['player']['captain']['shortname']+')</td><td class="text-center">'+response['player']['position']['shortname']+'</td></tr>')
                    updateTableRow('#table-players-on-bid', '#bidplayercount', false)
                } else if(response['type'] === 'coach') {
                    var table = $('#table-coaches > tbody:last');
                    table.append('<tr data-bidplayer="'+response['coach']['id']+'" class="border-top"><td class="text-center"></td><td class="text-left p-3">'+response['coach']['family']+' '+response['coach']['name'] +'</td><td class="text-center">'+response['coach']['post']['name']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                    updateTableRow('#table-coaches','#coachcount',true)

                    table = $('#table-coaches-on-bid > tbody:last');
                    table.append('<tr data-bidplayer="'+response['coach']['id']+'" class="border-top"><td class="text-center"></td><td class="text-left p-3">'+response['coach']['family']+' '+response['coach']['name'] +'</td><td class="text-center">'+response['coach']['post']['name']+'</td></tr>')
                    updateTableRow('#table-coaches-on-bid','#bidcoachcount',true)
                }

                $("#dropdownlistContentplayers input").val('');
                $("#message").html('Участник добавлен!');
                $('#messageNotification').jqxNotification({ template: 'info' });
                $("#messageNotification").jqxNotification("open");
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close');
            console.log('fail' + response);

            $("#message").html('Ошибка. ' + errorThrown);
            $('#messageNotification').jqxNotification({ template: 'error' });
            $("#messageNotification").jqxNotification("open");
        });
    });

    // если дефолт задан
    if($('#player').val() > 0) {
        $("#dropdownlistContentplayers input").val($('#_playerName').val());
        $("#choice").html("<span class='green'><strong>выбран: "+$('#_playerName').val() + "</strong></span>");
        $('#dol').jqxDropDownList('disabled', false);
        $('#position').jqxDropDownList('disabled', false);
        $('#photo').jqxDropDownList('disabled', false);
        $('#captain').jqxDropDownList('disabled', false);
        $("#save_button").prop('disabled', false );
        $("#photo_button").prop('disabled', false );
        $("#number").jqxNumberInput({ disabled: false });
        $("#dol").jqxDropDownList('selectIndex', $('#_dol').val());
        $("#position").jqxDropDownList('selectIndex', $('#_position').val());
        $("#captain").jqxDropDownList('selectIndex', $('#_captain').val());
        $('#number').val($('#_number').val());
    }
});
$(function () {
    // клик по удалению участника
    $('#table-players > tbody').on('click', '> tr > td.remove', function () {
        if(!confirm('Удалить участника?')) return false
        var $tr = $(this).parent()
        $.ajax({
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('removePlayer'),
            data: {
                "bid": $('#bid_id').val(),
                "type": 0,
                "id": $tr.attr('data-bidplayer'),
                "team": $('#team_id').val(),
            }
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $tr.remove()
                $('#table-players-on-bid tbody tr[data-bidplayer="'+$tr.attr('data-bidplayer')+'"]').remove()
                if(response['player']['unbid_id'] == $('#bid_id').val() && response['player']['unbid_id'] != response['player']['bid_id']) {
                    // добавить в отзаявку
                    var table = $('#table-players-on-unbid > tbody:last');
                    table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +'</td><td class="text-center"></td><td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td></tr>')
                    updateTableRow('#table-players-on-unbid', '#unbidplayercount', false)
                }
                updateTableRow('#table-players', '#playercount', false)
                updateTableRow('#table-players-on-bid', '#bidplayercount', true)
                $("#message").html('Участник удалён!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)

            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
    // клик по удалению тренерского штаба
    $('#table-coaches  > tbody').on('click', '> tr > td.remove',function () {
        if(!confirm('Удалить Представителя команды?')) return false
        var $tr = $(this).parent()
        $.ajax({
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('removePlayer'),
            data: {
                "bid": $('#bid_id').val(),
                "type": 1,
                "id": $tr.attr('data-bidplayer'),
                "team": $('#team_id').val(),
            }
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $tr.remove()
                $('#table-coaches-on-bid tbody tr[data-bidplayer="'+$tr.attr('data-bidplayer')+'"]').remove()
                console.log(response)
                if(response['coach']['unbid_id'] == $('#bid_id').val() && response['coach']['unbid_id'] != response['coach']['bid_id']) {
                    // добавить в отзаявку
                    var table = $('#table-coaches-on-unbid > tbody:last');

                    table.append('<tr data-bidplayer="'+response['coach']['id']+'" class="border-top"><td class="text-center"></td><td class="text-left p-3">'+response['coach']['family']+' '+response['coach']['name'] +'</td><td class="text-center"></td><td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td></tr>')
                    updateTableRow('#table-coaches-on-unbid', '#unbidcoachcount', true)
                }
                updateTableRow('#table-coaches', '#coachcount', true)
                updateTableRow('#table-coaches-on-bid', '#bidcoachcount', true)
                $("#message").html(response['text'])
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)

            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
    // клик по возвращению игрока в команду
    $('#table-players-on-unbid > tbody').on('click', '> tr > td.remove', function () {
        if(!confirm('Отменить отзаявку и вернуть игрока в команду?')) return false
        var $tr = $(this).parent()
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('cancelremovePlayer'),
            data: {
                "bid": $('#bid_id').val(),
                "type": 0,
                "id": $tr.attr('data-bidplayer'),
                "team": $('#team_id').val(),
            }
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $tr.remove()
                // добавить строку снова
                var table = $('#table-players > tbody:last');
                if(response['player']['captain_id'] === 0)
                    table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +'</td><td class="text-center">'+response['player']['position']['shortname']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                else table.append('<tr data-bidplayer="'+response['player']['id']+'" class="border-top"><td class="text-center">'+response['player']['number']+'</td><td class="text-left p-3">'+response['player']['family']+' '+response['player']['name'] +' ('+response['player']['captain']['shortname']+')</td><td class="text-center">'+response['player']['position']['shortname']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                updateTableRow('#table-players', '#playercount', false)
                updateTableRow('#table-players-on-unbid', '#unbidplayercount', false)
                $("#message").html('Участник возвращён в команду!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)

            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
    // клик по возвращению представителя в команду
    $('#table-coaches-on-unbid > tbody').on('click', '> tr > td.remove',function () {
        if(!confirm('Отменить отзаявку и вернуть представителя в команду?')) return false
        var $tr = $(this).parent()
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('cancelremovePlayer'),
            data: {
                "bid": $('#bid_id').val(),
                "type": 1,
                "id": $tr.attr('data-bidplayer'),
                "team": $('#team_id').val(),
            }
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                $tr.remove()
                // добавить строку снова
                var table = $('#table-coaches > tbody:last');
                table.append('<tr data-bidplayer="'+response['coach']['id']+'" class="border-top"><td class="text-center"></td><td class="text-left p-3">'+response['coach']['family']+' '+response['coach']['name'] +'</td><td class="text-center">'+response['coach']['post']['name']+'</td><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td></tr>')
                updateTableRow('#table-coaches', '#coachescount', true)
                updateTableRow('#table-coaches-on-unbid', '#unbidcoachescount', true)
                $("#message").html('Представитель возвращён в команду!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            console.log('fail' + response)

            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })
})


function clearForm() {
    $("#player").attr("value","0");
    $("#photo_id").attr("value","0");
    $("#photo").jqxDropDownList('selectIndex', 0 );
    $("#position").jqxDropDownList('selectIndex', 2 );
    $("#dol").jqxDropDownList('selectIndex', 5 );
    $("#captain").jqxDropDownList('selectIndex', 0 );
    $("#choice").html("<span class=\"red\"> не выбран </span>");
    $("#photo").jqxDropDownList('clear');
    $("#photo").jqxDropDownList('addItem', { label: '/storage/images/no_image.png', value: 0 } );
    $("#position").jqxDropDownList({ disabled: true });
    $("#dol").jqxDropDownList({ disabled: true });
    $("#captain").jqxDropDownList({ disabled: true });
    $("#photo").jqxDropDownList({ disabled: true });
    $("#number").jqxNumberInput({ disabled: true });
    $("#save_button").prop('disabled', true );
    $("#photo_button").prop('disabled', true );
    $('#number').val(0);
    $('#player').val(0);
    $('#photo_id').val(0);
    $("#dropdownlistContentplayers input").val('');
}

function updateTableRow(table, counter, isNumber) {
    $(table+' tr').each(function(row){
        if(row > 0) {
            $(this).removeClass('bg-light')
            if(row % 2 == 0) $(this).addClass('bg-light')
        }
        if(isNumber) {
            $(this).find('td').each(function(cell){
                if(cell == 0) {
                    $(this).html(row + '.')
                }
            })
        }
    })
    $(counter).html($(table +' > tbody > tr').length - 1)
}

