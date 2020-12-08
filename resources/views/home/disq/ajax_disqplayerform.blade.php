<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Дисквалификации игрока</h4>
            </div>
            <div class="modal-body">
                <form id="formValCard" class="form-horizontal form-label-left">
                    <h3>{{ $player->family }} {{ $player->name }} ({{ $player->team }})</h3>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Количество игр</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="matches" type="number" value="{{ $player->matches }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Осталось</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="elapsed" type="number" value="{{ $player->elapsed }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-3 col-sm-3 col-xs-6">Комментарий</label>
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <input id="comment" class="w-100" value="{{ $player->comment }}">
                        </div>
                    </div>
                    <div class="form-group row">Матчи:</div>
                    <div class="modal-body window-scrollable">

                        <table class="w-100">
                            <thead>
                            <tr>
                                <th class="w-15 text-center">Дата</th>
                                <th class="text-center" colspan="3">Игра</th>
                                <th class="w-10 text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matches as $match)
                                <tr>
                                    <td class="text-center"><small>@if($match->datetime){{ date('d.m.y   H:i', strtotime($match->datetime)) }}@endif</small></td>
                                    <td class="text-right">{{ $match->home_team }}</td>
                                    <td class="text-center"> - </td>
                                    <td class="text-left">{{ $match->away_team }}</td>
                                    <td class="pt-3"><input class="player-mode" type="checkbox" name="game[{{ $match->id }}]" match_id="{{ $match->id }}" @if($disqMatches->contains('id', $match->id)) checked @endif disabled /></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="saveEdit" type="button" class="btn btn-success hidden" data-id="{{ $player->id }}">Сохранить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#matches').jqxNumberInput({ width: '70px', height: '30px', spinButtons: true, digits: 2,
        inputMode: 'simple', decimalDigits: 0, min: 1, max: 50, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    $('#elapsed').jqxNumberInput({ width: '70px', height: '30px', spinButtons: true, digits: 2, disabled: true,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 50, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    $('#comment').jqxInput({placeHolder: "Комментарий", height: 30, width: '100%', theme: 'bootstrap' })
    $('#comment').on('input', function (event) {
        $('#saveEdit').removeClass('hidden')
    })


    $('#dialog').modal('toggle')

    $('#matches').on('valueChanged', function (event) {
        $('#saveEdit').removeClass('hidden')
    })
    $('#saveEdit').on('click', function () {
        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('admin_tourndisqplayerchange') }}',
            data: {id: $(this).attr("data-id"), matches: $('#matches').val(), comments: $('#comment').val() },
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
                // изменена дисквалификация
                var gg = $('#table-disq tbody tr[data-id="'+response['disq']['id']+'"]')
                if(gg) {
                    gg.find('td').each(function(cell){
                        if(cell == 5) $(this).html('<small class="ml-2 hidden-xs">'+response['disq']['comment']+'</small>')
                        else if(cell == 6) $(this).html(response['disq']['matches'])
                        else if(cell == 7) $(this).html(response['disq']['elapsed'])
                    })
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
</script>
