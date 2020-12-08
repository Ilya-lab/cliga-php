<div class="modal fade" id="dialogClock" role="dialogClock" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Минуты вратаря</h4>
            </div>
            <div class="modal-body">
                <h3 id="familyClock">{{ $family }}</h3>
                <form id="formValCard" class="form-horizontal form-label-left">
                    @if($hasMinute)
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-6 col-sm-6 col-xs-12">Общее количество минут на поле</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minuteAllClock"></div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="isGK" class="control-label col-md-6 col-sm-6 col-xs-12">Вратарь в игре</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="gkPlayed" class="player-mode player-start" type="checkbox" @if($gk) checked @endif>
                        </div>
                    </div>
                    @if($hasGKMinute)
                    <div class="form-group row">
                        <label for="minuteCard" class="control-label col-md-6 col-sm-6 col-xs-12">Минуты вратарём в поле</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minuteClock"></div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resultSaveGKMinute" class="btn btn-success">Записать</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#dialogClock').modal('toggle')
    @if($hasMinute)
    $('#minuteAllClock').jqxNumberInput({ value: {{ $minute }}, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    @endif
    @if($hasGKMinute)
    @php
    if(!$gk) $minuteGK = $maxMinute;
    @endphp
    $('#minuteClock').jqxNumberInput({ value: {{ $minuteGK }}, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap', disabled: @if($gk) false @else true @endif })
    if($("input").is("#gkPlayed")) {
        $('#gkPlayed').on('change', function (event) {
            // стартовый состав
                $('#minuteClock').jqxNumberInput({ disabled: !$(this).is(":checked") })
        })
    }
    @endif

    $( "#resultSaveGKMinute").click(function() {
        $('#dialogClock').modal('toggle')
        $('#loader').jqxLoader('open')
        var mminuteAll = 0
        var mminuteGK = 0
        @if($hasMinute)
        mminuteAll = $('#minuteAllClock').val()
        @endif
        @if($hasGKMinute)
        mminuteGK = $('#minuteClock').val()
        @endif
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('minupdateRoute'),
            data: {id: $('#_match').val(), player_id: $('#_currentPlayer').val(), gk: $('#gkPlayed').is(":checked"), minute: mminuteAll, gkminute: mminuteGK, table: true},
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
            console.log(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // обработка ответа
                $('#eventbox').html(response['eventTable'])
                $("#box{{ $team_id }}").html(response['table'])
                $("#message").html('Минуты игрока в матче записаны!')
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
</script>
