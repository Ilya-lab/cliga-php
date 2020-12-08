<div class="m-3">
    <table class="w-100" id="table-settings">
        <tr>
            <th class="text-center">Наименование</th>
            <th class="text-center" colspan="2">Значение</th>
        </tr>
        <tbody>
        <?php if($roles->contains(1)): ?>
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?> " data-setting-id="<?php echo e($setting->key); ?>">
                    <td class="text-left p-3"><?php echo e($setting->name); ?></td>
                    <?php if($setting->type_field == "bool"): ?>
                    <td align="center" class="text-center"><input type="checkbox" id="<?php echo e($setting->key); ?>" class="<?php echo e($setting->type_field); ?>" <?php echo e($setting->value == 1 ? 'checked' : ''); ?>></td>
                    <?php else: ?>
                    <td class="text-center"><input id="<?php echo e($setting->key); ?>" class="<?php echo e($setting->type_field); ?>" value="<?php echo e($setting->value); ?>"></td>
                    <?php endif; ?>
                    <td class="text-center remove"><i class="fa fa-close" title="Удалить событие"></i></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?> " data-setting-id="<?php echo e($setting->key); ?>">
                <td class="text-left p-3"><?php echo e($setting->name); ?></td>
                <td class="text-center"><?php echo e($setting->value); ?></td>
                <td></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php if($roles->contains(1)): ?>
        <div class="row mt-5">
            <button id="addButton" class="btn btn-primary">Добавить</button>
        </div>
    <?php endif; ?>
</div>
<p>Итого настроек в соревновании: <strong class="red"><?php echo e($settings->count()); ?></strong></p>
<script>
    if($("input").is(".uint")) {
        $('.uint').jqxNumberInput({ width: '70px', height: '30px', spinButtons: true, digits: 3,
            inputMode: 'simple', decimalDigits: 0, min: 0, max: 150, spinButtonsWidth: 20, textAlign: 'center',
            allowNull: true, theme: 'bootstrap' })
        $('.uint').on('valueChanged', function (event)
        {
            saveSetting($(this).parent().parent().attr('data-setting-id'), event.args.value)
        })
    }
    if($("input").is(".bool")) {
        $('.bool').jqxCheckBox({ height: 30, width: 70, theme: 'bootstrap' })
        $('.bool').on('change', function (event) {
            saveSetting($(this).parent().parent().attr('data-setting-id'), event.args.checked ? 1 : 0)
        })
    }
    <?php if($roles->contains(1)): ?>
    $( "#addButton" ).click(function(){
        $('#loader').jqxLoader('open')
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo e(route('admin_tournsettingsview')); ?>',
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
                // загружена форма ввода состава команды
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
        console.log('LL')
        if (!confirm('Удалить настройку соревнования?')) return false

            $('#loader').jqxLoader('open')
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '<?php echo e(route('setting_remove')); ?>',
                data: { id: <?php echo e($tournament->id); ?>, key: $(this).parent().attr('data-setting-id'), table: true },
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
                    // обработка ответа
                    $('#settingsbox').html(response['table'])
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

    function saveSetting(key, value) {
       $('#loader').jqxLoader('open')
        $.ajax({
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo e(route('setting_change')); ?>',
            data: { id: <?php echo e($tournament->id); ?>, key: key, value: value, table: true },
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
                // обработка ответа
                $('#settingsbox').html(response['table'])
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
    }
    <?php endif; ?>
</script>
