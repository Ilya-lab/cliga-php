<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Состав команды «{{ $team }}»</h4>
            </div>
            <div class="modal-body window-scrollable">

                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="w-15 text-center">Ном.</th>
                            <th class="text-center">Игрок</th>
                            <th class="w-10 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        @php
                        $found = $matchPlayers->contains('player_id', $player->tournplayer_id);
                        $gk = false;
                        $number = $player->number;
                        if($found) {
                            $gk = $matchPlayers->firstWhere('player_id', $player->tournplayer_id)->is_goalkeeper;
                            $number = $matchPlayers->firstWhere('player_id', $player->tournplayer_id)->number;
                        }
                        @endphp
                    <tr class="border-top @if(!$found)player-bg-disabled @endif" player_id="{{ $player->tournplayer_id }}">
                        <td class="text-center" valign="middle"><input class="player-number" name="numcom[{{ $player->tournplayer_id }}]" type="number" value="{{ $number }}" min="0" max="99" player_id="{{ $player->tournplayer_id }}" style="min-width: 70px;" @if(!$found)disabled @endif/></td>
                        <td class="text-left p-3">{{ $player->family }} {{ $player->name }}<br><i class="small">{{ $player->position->name }}</i></td>
                        <td class="text-center">
                            <table>
                                <tbody>
                                <tr>
                                    <td align="left" valign="middle" class="pt-2">
                                        <label>
                                            <input class="player-mode player-start" type="checkbox" name="plcom[{{ $player->tournplayer_id }}]" player_id="{{ $player->tournplayer_id }}" position_id="{{ $player->position->id }}" @if($found) checked @endif/>игра
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle">
                                        <label>
                                            <input class="player-mode player-gk" type="checkbox" name="plgk[{{ $player->tournplayer_id }}]" player_id="{{ $player->tournplayer_id }}" @if(!$found) disabled @endif @if($gk) checked @endif/>врат
                                        </label>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="text-left">Выбрано - <span id="headcount" style="font-weight: bold;">{{ $matchPlayers->count() }}</span></div>
                <button type="button" id="resultButton" class="btn btn-success">Ввести состав</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="currentteam" value="{{ $team_id }}">
<script>
    $('#dialog').modal('toggle')
    if($("input").is(".player-number")) {
        $('.player-number').jqxNumberInput({ value: 0, width: '100%', height: '40px', spinButtons: true, digits: 2,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 99, spinButtonsWidth: 20, textAlign: 'center',
            allowNull: true, theme: 'bootstrap' })
        if($("table").is("tr.player-bg-disabled > td .player-number")) $("tr.player-bg-disabled > td .player-number").jqxNumberInput({ disabled: true })
        $('.player-number').on('change', function (event)
        {
            var value = event.args.value
            var id = $(this).parent().parent().attr("player_id")
            $("input[name='numcom"+"["+id+"]']").attr('value',value)
        })
    }
    $('.player-start').on('change', function (event) {
        // стартовый состав
        var sbname = $("input[name='numcom"+"["+$(this).attr('player_id')+"]']")
        sbname.jqxNumberInput({ disabled: true })
        if($(this).is(":checked")) {
            sbname.jqxNumberInput({ disabled: false })
            $("tr[player_id='"+$(this).attr('player_id')+"']").removeClass("player-bg-disabled")
            $("#headcount").html(parseInt($("#headcount").html()) + 1)
            $(".player-gk[player_id='"+$(this).attr('player_id')+"']").attr('disabled', false)
            if(parseInt($(this).attr('position_id')) == 1) $(".player-gk[player_id='"+$(this).attr('player_id')+"']").attr('checked', true)
        } else {
            $("tr[player_id='"+$(this).attr('player_id')+"']").addClass("player-bg-disabled")
            $(".player-gk[player_id='"+$(this).attr('player_id')+"']").attr('disabled', true)
            $(".player-gk[player_id='"+$(this).attr('player_id')+"']").attr('checked', false)
            $("#headcount").html(parseInt($("#headcount").html()) - 1)
        }
    })
    $( "#resultButton").click(function(){
        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        inSostav = {}
        $('input.player-start:checked').each(function() {
            var t = $('input.player-gk:checked[player_id='+$(this).attr('player_id')+']')
            var gk = false
            if(t.length > 0) gk = true
            inSostav['player_'+$(this).attr('player_id')] = {player_id: $(this).attr('player_id'), number: $("input[name='numcom"+"["+$(this).attr('player_id')+"]']").val(), gk: gk}
        })
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('admin_saveteammatch') }}',
            data: {id: $('#_match').val(), team: $('#currentteam').val(), sostav: inSostav, table: true},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            try {
                response = JSON.parse(response)
            } catch(errorThrown) {
                console.log(errorThrown)
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            }
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // загружен состав команды
                $("#box{{ $team_id }}").html(response['table'])
                $("#eventbox").html(response['eventTable'])
                memberPlayers[{{ $team_id }}] = response['players']

                var cb = null
                if($('#homeDefenders').length > 0 && {{ $team_id }} == $('#_home').val()) cb = $('#homeDefenders')
                if($('#awayDefenders').length > 0 && {{ $team_id }} == $('#_away').val()) cb = $('#awayDefenders')
                if(cb) {
                    var selVal = cb.jqxDropDownList('getSelectedItem').value
                    cb.jqxDropDownList('clear')
                    cb.jqxDropDownList('addItem', { label: 'Не выбран', value: 0} )
                    var k = 0
                    var ff = false
                    response['players'].forEach(function(entry) { // за свои
                        k++
                        var str = entry.family + ' ' + entry.name + ' (' + entry.position_shortname + ')'
                        if(entry.number > 0) str = entry.number + ' - ' + str
                        cb.jqxDropDownList('addItem', { label: str, value: entry.player_id } )
                        if(selVal == entry.player_id) {
                            cb.jqxDropDownList('selectIndex', k)
                            ff = true
                        }
                    })
                    if(!ff) cb.jqxDropDownList('selectIndex', 0 )
                }

                if($('#mvp').length > 0) {
                    cb = $('#mvp')
                    var selVal = cb.jqxDropDownList('getSelectedItem').value
                    loading = true
                    cb.jqxDropDownList('clear')
                    cb.jqxDropDownList('addItem', { label: 'Не выбран', value: 0, group: 'Не выбран'} )
                    var k = 0
                    var ff = false

                    if($('#_home').val() > 0) {
                        memberPlayers[$('#_home').val()].forEach(function(entry) { // за свои
                            k++
                            var str = entry.family + ' ' + entry.name + ' (' + entry.position_shortname + ')'
                            if(entry.number > 0) str = entry.number + ' - ' + str
                            cb.jqxDropDownList('addItem', { label: str, value: entry.player_id, group: $('#home_button').html() } )
                            if(selVal == entry.player_id) {
                                cb.jqxDropDownList('selectIndex', k)
                                ff = true
                            }
                        })
                    }
                    if($('#_away').val() > 0) {
                        memberPlayers[$('#_away').val()].forEach(function(entry) { // за свои
                            k++
                            var str = entry.family + ' ' + entry.name + ' (' + entry.position_shortname + ')'
                            if(entry.number > 0) str = entry.number + ' - ' + str
                            cb.jqxDropDownList('addItem', { label: str, value: entry.player_id, group: '"'+$('#away_button').html()+'"' } )
                            if(selVal == entry.player_id) {
                                cb.jqxDropDownList('selectIndex', k)
                                ff = true
                            }
                        })
                    }
                    loading = false
                    if(!ff) cb.jqxDropDownList('selectIndex', 0 )
                }

                $("#message").html('Состав на матч записан!')
                $('#messageNotification').jqxNotification({ template: 'info' })
                $("#messageNotification").jqxNotification("open")
            }
        }).fail(function(response, textStatus, errorThrown) {
            $('#loader').jqxLoader('close')
            $("#message").html('Ошибка. ' + errorThrown)
            $('#messageNotification').jqxNotification({ template: 'error' })
            $("#messageNotification").jqxNotification("open")
            console.log('fail' + response)
        })
    })
</script>
