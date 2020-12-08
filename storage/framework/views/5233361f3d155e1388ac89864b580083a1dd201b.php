<?php $__env->startSection('title'); ?>Дисквалифицированные игроки <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?><script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcombobox.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownbutton.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button>
    <div class="ln_solid"></div>
    <div id="grid" data-back-route="<?php echo e(route('admin_showtournament', $tournament->id)); ?>"></div>
    <div id="loader"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>

    <?php $__env->startComponent('components.main_block'); ?>
        <?php $__env->slot('title'); ?>Дисквалификации <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Игроки, имеющие дисквалификации в туринре - <?php echo e($tournament->name); ?><?php $__env->endSlot(); ?>
        <div class="m-1">
            <table id="table-disq" class="w-100">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Игрок</th>
                    <th class="text-center hidden-xs">Позиция</th>
                    <th class="text-center hidden-xs">Команда</th>
                    <th class="text-center hidden-xs">Матч</th>
                    <th class="text-center"><div class="hidden-xs">Причина</div></th>
                    <th class="text-center">Кол.игр</th>
                    <th class="text-center">Ост.игр</th>
                    <?php if(!$closed): ?><th class="text-center"></th><?php endif; ?>
                </tr>
                <tbody>
                <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?> " data-id="<?php echo e($player->id); ?>">
                        <td class="text-center p-2"><?php echo e($loop->index + 1); ?></td>
                        <td class="text-left disqview" <?php if(!$closed): ?>  style="cursor: pointer;" <?php endif; ?>><?php echo e($player->family); ?> <?php echo e($player->name); ?></td>
                        <td class="text-center hidden-xs"><small><?php echo e($player->position); ?></small></td>
                        <td class="text-center hidden-xs"><small><?php echo e($player->team); ?></small></td>
                        <td class="text-center hidden-xs"><small><?php echo e($player->home_team); ?> - <?php echo e($player->away_team); ?></small></td>
                        <td class="text-left"><img src="<?php echo e($player->type_id == 1 ? asset('/images/icons/yellow.png') : asset('/images/icons/red.png')); ?>"><small class="ml-2 hidden-xs"><?php echo e($player->comment); ?></small></td>
                        <td class="text-center"><?php echo e($player->matches); ?></td>
                        <td class="text-center"><?php echo e($player->elapsed); ?></td>
                        <?php if(!$closed): ?><td class="text-center remove"><i class="fa fa-close" title="Удалить игрока из дисквалификации"></i></td><?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <p>Итого дисквалификаций: <strong id="disq-count" class="red"><?php echo e($players->count()); ?></strong></p>
        <?php if(!$closed): ?>
            <div class="row mt-5">
                <button id="addButton" class="btn btn-primary">Добавить</button>
            </div>
        <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
<div id="ajax"></div>
<script>
    $(document).ready(function () {
        $('#back').on('click', function () {
            document.location.href = $('#grid').data('backRoute')
        })
        $('#addButton').on('click', function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('admin_tournadddisqplayerview')); ?>',
                data: {id: <?php echo e($tournament->id); ?> },
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
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    // загружена форма вывода параметров дисквалификации
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
        $('table').on('click', 'td.remove',function () {
            if (!confirm('Удалить дисквалификацию игрока?')) return false
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('admin_tourndeletedisqplayer')); ?>',
                data: {id: $(this).parent().attr("data-id") },
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
                    // удалить строку
                    $('table tbody tr[data-id="'+response['disq']['id']+'"]').remove()
                    $('#disq-count').html($('#table-disq tr').length-1)
                    $('#messageNotification').jqxNotification({ template: 'info' })
                }
                $("#message").html(response['text'])
                $("#messageNotification").jqxNotification("open")
            }).fail(function(response, textStatus, errorThrown) {
                console.log('fail' + response)
                $('#loader').jqxLoader('close')
                $("#message").html('Ошибка. ' + errorThrown)
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            })
        })
        $('table').on('click', 'td.disqview',function () {
            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('admin_tourndisqplayerview')); ?>',
                data: {id: $(this).parent().attr("data-id") },
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
                    $("#message").html('Ошибка. ' + response['text'])
                    $('#messageNotification').jqxNotification({ template: 'error' })
                    $("#messageNotification").jqxNotification("open")
                } else {
                    // загружена форма вывода параметров дисквалификации
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
    })
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>