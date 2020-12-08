<div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Корректировка матча</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Номер матча</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="numberMatch" class="position-sticky" value="<?php echo e($match->number); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Арена (площадка)</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="arenaMatch" class="position-sticky">
                                <option value="0">Не выбрано</option>
                                <?php $__currentLoopData = $arenas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arena): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($arena->field && $arena->field->arena): ?>
                                        <option value="<?php echo e($arena->id); ?>" <?php if($arena->id == $match->arena_id): ?> selected <?php endif; ?>><?php echo e($match->arena_id); ?> - <?php echo e($arena->field->arena->name); ?> (<?php echo e($arena->field->name); ?>)</option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Дата и время матча</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="datetimeMatch" class="position-sticky"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Хозяева</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="homeMatch" class="position-sticky">
                                <option value="0">Не выбрано</option>
                                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($team->id); ?>" <?php if($team->id == $match->home_id): ?> selected <?php endif; ?>><?php echo e($team->name); ?> (<?php echo e($team->city); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Гости</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="awayMatch" class="position-sticky">
                                <option value="0">Не выбрано</option>
                                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($team->id); ?>" <?php if($team->id == $match->away_id): ?> selected <?php endif; ?>><?php echo e($team->name); ?> (<?php echo e($team->city); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="editButton" class="btn btn-success">Изменить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#dialog').modal('toggle')
    $('#arenaMatch').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#homeMatch').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#awayMatch').jqxDropDownList({ autoDropDownHeight: true, width: '100%', height: '35px', theme: 'bootstrap'})
    $('#numberMatch').jqxInput({ width: '100%', height: '35px', theme: 'bootstrap' })
    var dt = new Date(<?php echo e(Carbon\Carbon::parse($match->datetime)->format('U')*1000); ?>)
    <?php if($match->datetime == null): ?> dt = null; <?php endif; ?>
    $("#datetimeMatch").jqxDateTimeInput({ formatString: 'dd.MM.yyyy   HH:mm', firstDayOfWeek: 1, culture: 'ru-RU',
        showTimeButton: true, width: '300px', height: '35px', value: dt, showFooter:true, clearString:'Очистить', todayString: 'Сегодня' })
    $('#editButton').on('click', function () {
        if($('#arenaMatch').val() == 0) {
            alert('Выберите арену из списка')
            return false
        }
        $('#dialog').modal('toggle')
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#grid').data('editRoute'),
            data: {id: <?php echo e($match->id); ?>, 'datetime': $('#datetimeMatch').val(), 'arena_id': $('#arenaMatch').val(), 'number': $('#numberMatch').val(), 'home_id': $('#homeMatch').val(), 'away_id': $('#awayMatch').val() },
        }).done(function(response) {
            console.log(response)
            response = JSON.parse(response)
            $('#loader').jqxLoader('close')
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                var gg = $('#table-'+response['match']['mainstage_id']+' tbody tr[data-match-id="'+response['match']['id']+'"]')
                if(gg) {
                    gg.find('td').each(function(cell){
                        if(cell == 0) $(this).html(response['match']['number'])
                        else if(cell == 1) $(this).html('<small>'+response['match']['datetime']+'</small>')
                        else if(cell == 3) $(this).html(response['match']['place']['field']['arena']['name']+' ('+response['match']['place']['field']['number']+')')
                        else if(cell == 4) $(this).html(response['match']['home']['name'])
                        else if(cell == 6) {
                            if(response['match']['away']) $(this).html(response['match']['away']['name'])
                            else $(this).html('<small class="red">нет</small>')
                        }
                    })
                }
                $("#message").html('Матч изменён!')
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
