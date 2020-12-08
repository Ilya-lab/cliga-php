<div class="modal fade" id="dialogClock" role="dialogClock" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Минуты вратаря</h4>
            </div>
            <div class="modal-body">
                <h3 id="familyClock"><?php echo e($family); ?></h3>
                <form id="formValCard" class="form-horizontal form-label-left">
                    <?php if($hasMinute): ?>
                    <div class="form-group row">
                        <label for="minuteAllClock" class="control-label col-md-6 col-sm-6 col-xs-12">Общее количество минут на поле</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minuteAllClock"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group row">
                        <label for="isGK" class="control-label col-md-6 col-sm-6 col-xs-12">Вратарь в игре</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="gkPlayed" class="player-mode player-start" type="checkbox" <?php if($gk): ?> checked <?php endif; ?>>
                        </div>
                    </div>
                    <?php if($hasGKMinute): ?>
                    <div class="form-group row">
                        <label for="minuteCard" class="control-label col-md-6 col-sm-6 col-xs-12">Минуты вратарём в поле</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="minuteClock"></div>
                        </div>
                    </div>
                    <?php endif; ?>
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
    <?php if($hasMinute): ?>
    $('#minuteAllClock').jqxNumberInput({ value: <?php echo e($minute); ?>, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap' })
    <?php endif; ?>
    <?php if($hasGKMinute): ?>
    <?php
    if(!$gk) $minuteGK = $maxMinute;
    ?>
    $('#minuteClock').jqxNumberInput({ value: <?php echo e($minuteGK); ?>, width: 70, height: 30, spinButtons: true, digits: 3,
        inputMode: 'simple', decimalDigits: 0, min: 0, max: 120, spinButtonsWidth: 20, textAlign: 'center',
        allowNull: true, theme: 'bootstrap', disabled: <?php if($gk): ?> false <?php else: ?> true <?php endif; ?> })
    if($("input").is("#gkPlayed")) {
        $('#gkPlayed').on('change', function (event) {
            // стартовый состав
                $('#minuteClock').jqxNumberInput({ disabled: !$(this).is(":checked") })
        })
    }
    <?php endif; ?>

    $( "#resultSaveGKMinute").click(function() {
        $('#dialogClock').modal('toggle')
        $('#loader').jqxLoader('open')
        var mminuteAll = 0
        var mminuteGK = 0
        <?php if($hasMinute): ?>
        mminuteAll = $('#minuteAllClock').val()
        <?php endif; ?>
        <?php if($hasGKMinute): ?>
        mminuteGK = $('#minuteClock').val()
        <?php endif; ?>
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('minupdateRoute'),
            data: {id: $('#_match').val(), player_id: $('#_currentPlayer').val(), gk: $('#gkPlayed').is(":checked"), minute: mminuteAll, gkminute: mminuteGK, table: true},
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response)
            console.log(response)
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // обработка ответа
                $('#eventbox').html(response['eventTable'])
                $("#box<?php echo e($team_id); ?>").html(response['table'])
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
