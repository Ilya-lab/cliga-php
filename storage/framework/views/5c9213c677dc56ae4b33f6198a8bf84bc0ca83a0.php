<div class="modal fade bs-modal" id="dialogForma" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Выбор формы команд</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="form-group row">
                        <table class="w-100">
                            <tr>
                                <th width="45%" class="text-center"><h3><?php if( $match->home): ?><?php echo e($match->home->name); ?><?php else: ?> хозяева <?php endif; ?></h3></th>
                                <th width="10%"></th>
                                <th width="45%" class="text-center"><h3><?php if( $match->away): ?><?php echo e($match->away->name); ?><?php else: ?> гости <?php endif; ?></h3></th>
                            </tr>
                            <tr>
                                <td class="text-center">футболка</td>
                                <td></td>
                                <td class="text-center">футболка</td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <select id="homeShirt" class="formacolor">
                                        <option value="0">Не выбрано</option>
                                        <?php $__currentLoopData = $colorforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($forma->id); ?>"><?php echo e($forma->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td></td>
                                <td class="text-center">
                                    <select id="awayShirt" class="formacolor">
                                        <option value="0">Не выбрано</option>
                                        <?php $__currentLoopData = $colorforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($forma->id); ?>"><?php echo e($forma->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">шорты</td>
                                <td></td>
                                <td class="text-center">шорты</td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <select id="homeShorts" class="formacolor">
                                        <option value="0">Не выбрано</option>
                                        <?php $__currentLoopData = $colorforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($forma->id); ?>"><?php echo e($forma->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td></td>
                                <td class="text-center">
                                    <select id="awayShorts" class="formacolor">
                                        <option value="0">Не выбрано</option>
                                        <?php $__currentLoopData = $colorforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($forma->id); ?>"><?php echo e($forma->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveFormaButton" class="btn btn-success">Записать</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#dialogForma').modal('toggle')
    $('.formacolor').jqxDropDownList({ height: 30, width: '100%' })
    $('#homeShirt').jqxDropDownList('selectItem', $('#homeShirt').jqxDropDownList('getItemByValue', <?php echo e($match->homeshirt_id); ?>))
    $('#homeShorts').jqxDropDownList('selectItem', $('#homeShorts').jqxDropDownList('getItemByValue', <?php echo e($match->homeshorts_id); ?>))
    $('#awayShirt').jqxDropDownList('selectItem', $('#awayShirt').jqxDropDownList('getItemByValue', <?php echo e($match->awayshirt_id); ?>))
    $('#awayShorts').jqxDropDownList('selectItem', $('#awayShorts').jqxDropDownList('getItemByValue', <?php echo e($match->awayshorts_id); ?>))
    $( "#saveFormaButton").click(function() {
        $('#dialogForma').modal('toggle')
        $('#loader').jqxLoader('open')

        $.ajax({
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo e(route('admin_saveforma')); ?>',
            data: {id: $('#_match').val(), homeshirt: $('#homeShirt').val(), homeshorts: $('#homeShorts').val(), awayshirt: $('#awayShirt').val(), awayshorts: $('#awayShorts').val() },
        }).done(function(response) {
            $('#loader').jqxLoader('close')
            response = JSON.parse(response);
            if(response['status'] === 'fail') {
                console.log(response['text'])
                $("#message").html('Ошибка. ' + response['text'])
                $('#messageNotification').jqxNotification({ template: 'error' })
                $("#messageNotification").jqxNotification("open")
            } else {
                // форма записана
                $("#message").html('Форма команд на матч записана!')
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
