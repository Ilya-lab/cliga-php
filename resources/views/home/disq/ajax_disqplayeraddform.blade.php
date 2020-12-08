<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить дисквалификацию</h4>
            </div>
            <div class="modal-body">
                <form id="formValCard" class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Команда</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select id="teams">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }} @if($team->city != "") ({{ $team->city }}) @endif</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Матч</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select id="match">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Игрок</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select id="player">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Тип дискв.</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select id="type">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Количество игр</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="matches" type="number" value="1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Комментарий</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <input id="comment" class="w-100" value="Дисквалифицирован за ...">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="saveAdd" type="button" class="btn btn-success" data-id="{{ $tourn_id }}">Добавить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#teams').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    if($('#teams').jqxDropDownList('getItems').length > 0) loadGames($('#teams').jqxDropDownList('val'))
    $('#player').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#match').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#matches').jqxNumberInput({ width: '70px', height: '30px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 1, max: 50, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    $('#type').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#comment').jqxInput({placeHolder: "Комментарий", height: 30, width: '100%', theme: 'bootstrap' })

    $('#dialog').modal('toggle')

    $('#saveAdd').on('click', function () {
        if(!$('#player').jqxDropDownList('getSelectedItem')) {
            alert('Выберите игрока')
            return
        }
        if(!$('#match').jqxDropDownList('getSelectedItem')) {
            alert('Выберите матч')
            return
        }

        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('admin_tournadddisqplayer') }}',
            data: {tourn_id: {{ $tourn_id }}, match_id: $('#match').val(), player_id: $('#player').val(),
                matches: $('#matches').val(), type_id: $('#type').val(), comments: $('#comment').val() },
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            try {
                response = JSON.parse(response)
            } catch(errorThrown) {
                console.log(errorThrown)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            }

            if(response['status'] === 'fail') {
                console.log(response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
            } else {
                // добавлена дисквалификация
                var gg = $('#table-disq > tbody:last')
                if(gg) {
                    var row = '<tr class="border-top" data-id="'+response['disq']['id']+'">\n' +
                        '                        <td class="text-center p-2">'+$('#table-disq tr').length+'</td>\n' +
                        '                        <td class="text-left disqview" @if(!$closed)  style="cursor: pointer;" @endif>'+response['disq']['family']+' '+response['disq']['name']+'</td>\n' +
                        '                        <td class="text-center hidden-xs"><small>'+response['disq']['position']+'</small></td>\n' +
                        '                        <td class="text-center hidden-xs"><small>'+response['disq']['team']+'</small></td>\n' +
                        '                        <td class="text-center hidden-xs"><small>'+response['disq']['home_team']+' - '+response['disq']['away_team']+'</small></td>\n' +
                        '                        <td class="text-left">'
                    if(response['disq']['type_id'] == 1) row = row + '<img src="/images/icons/yellow.png">'
                    else row = row + '<img src="/images/icons/red.png">'
                    row = row + '<small class="ml-2 hidden-xs">'+response['disq']['comment']
                    row = row +'</small></td>\n' +
                        '                        <td class="text-center">'+response['disq']['matches']+'</td>\n' +
                        '                        <td class="text-center">'+response['disq']['elapsed']+'</td>\n' +
                        '                        <td class="text-center remove"><i class="fa fa-close" title="Удалить игрока из дисквалификации"></i></td>\n' +
                        '                    </tr>'
                    gg.append(row)
                    $('#disq-count').html($('#table-disq tr').length-1)
                }
                $('#messageNotification').jqxNotification({ template: 'info' })
            }
            $('#message').html(response['text'])
            $('#messageNotification').jqxNotification("open")
        }).fail(function(response, textStatus, errorThrown) {
            console.log('fail' + response)
            $('#loader').jqxLoader('close')
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
        })
    })

    $('#teams').on('change', function (event)
    {
        var args = event.args
        if (args) {
            loadGames(args.item.value)
        }
    })
    $('#match').on('change', function (event)
    {
        var args = event.args
        if (args) {
            var uurl = '{{ route('api_tournament_match_players', [ '###', '!!!']) }}'
            uurl = uurl.replace('###',args.item.value).replace('!!!', $('#teams').val())
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: uurl,
            }).done(function(response) {
                $('#player').jqxDropDownList('clear')
                for(var prop in response) {
                    var item = response[prop]
                    $('#player').jqxDropDownList('addItem', { label: item['number'] + ' - ' + item['family'] + ' ' + item['name'], value: item['player_id']} )
                }
                if(response.length > 0) $('#player').jqxDropDownList('selectIndex', 0 )
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                alert('Ошибка. ' + response)
            })
        }
    })

    function loadGames(team) {
        var uurl = '{{ route('api_tournament_team_matches', [$tourn_id, '###']) }}'
        uurl = uurl.replace('###',team)
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: uurl,
        }).done(function(response) {
            $('#match').jqxDropDownList('clear')
            for(var prop in response) {
                var item = response[prop]
                if(item['status_id'] == 2)
                    $('#match').jqxDropDownList('addItem', { label: item['home']['name'] + ' - ' + item['away']['name'], value: item['id']} )
            }
            if(response.length > 0) $('#match').jqxDropDownList('selectIndex', 0 )
        }).fail(function(response, textStatus, errorThrown) {
            console.log('fail' + response)
            alert('Ошибка. ' + response)
        })
    }
</script>
