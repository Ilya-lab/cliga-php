<?php $__env->startSection('title'); ?>Перечень соревнований <?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('js/translite.js')); ?>"></script>
<script src="<?php echo e(asset('js/other.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('js/datatables/jquery.dataTables.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/buttons.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/fixedHeader.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/responsive.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('js/datatables/scroller.bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('css/icheck/flat/green.css')); ?>" rel="stylesheet" type="text/css" />

<!-- editor -->
<link href="<?php echo e(asset('css/font-awesome.css?v1001')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/editor/external/google-code-prettify/prettify.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/editor/index.css')); ?>" rel="stylesheet">
<!-- select2 -->
<link href="<?php echo e(asset('css/select/select2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script src="<?php echo e(asset('js/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.bootstrap.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.html5.min.js?ff2')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/buttons.print.min.js?ff')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.fixedHeader.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.keyTable.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/responsive.bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatables/dataTables.scroller.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/icheck/icheck.min.js')); ?>"></script>
<!-- select2 -->
<script src="<?php echo e(asset('js/select/select2.full.js?dfv')); ?>"></script>

<script src="<?php echo e(asset('js/tinymce/tinymce.min.js')); ?>"></script>
<script>
    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    tinymce.init({
        selector: '#desc',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'forecolor backcolor | undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright',
        browser_spellcheck: true,
        language: 'ru',
        images_upload_url: 'postAcceptor.php',
        height: '300px',

        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'images/upload_desc');
            var token = '<?php echo e(csrf_token()); ?>';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP ошибка: ' + xhr.status)
                    return
                }
                if(!IsJsonString(xhr.responseText)) {
                    failure('Неправильный ответ от сервера')
                    console.log(xhr.responseText)
                    return false
                }
                try {
                    json = JSON.parse(xhr.responseText)
                } catch(errorThrown) {
                    console.log(errorThrown)
                    failure(json.error)
                    return false
                }
               //json = JSON.parse(xhr.responseText);
                if(json.status === 'ERROR') {
                    failure(json.error)
                    console.log(json)
                    return false
                }

                if(json.status === 'OK') {
                    success(json.location)
                }
            };
            formData = new FormData()
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('type', 'type_tourn');
            formData.append('url', $('#url').val());
            xhr.send(formData);
        },

        /* we override default upload handler to simulate successful upload*/
       /* images_upload_handler: function (blobInfo, success, failure) {
            console.log(blobInfo);
            $.post('images/upload_desc', tinymce.activeEditor.getContent(), {"_token": $('meta[name="csrf-token"]').attr('content')}).done(function() {
                console.log("Uploaded images and posted content as an ajax request.");
            });
        },*/
    });
</script>
<script src="<?php echo e(asset('js/pace/pace.min.js')); ?>"></script>
<script>
    var handleDataTableButtons = function() {
            "use strict";
            0 !== $("#datatable-responsive").length && $("#datatable-responsive").DataTable({
                dom: "Bfrtip",
                buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
                responsive: !0
            })
        },
        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons()
                }
            }
        }();
</script>
<script type="text/javascript">
    var newWin = null;
    $(document).ready(function() {
        $('#datatable-responsive').DataTable();
        $('#dialog').on('show.bs.modal', function () {
            $('#name').val('');
            $('#url').val('');
            $('#file').val('');
            $('#uploaded_preview').removeAttr('src');
            $('#uploaded_path').val('');
            $('#x1').val('');
            $('#x2').val('');
            $('#y1').val('');
            $('#y2').val('');
            $('#hh').val('');
            $('#ww').val('');
        });
        $('#dialog').on('hide.bs.modal', function () {
            if(newWin) newWin.close();
        });
        $('#save').on('click', function () {
            if(!empty($('#name').val())) {
                $('#name').prop('disabled', true);
                $('#save').prop('disabled', true);
                $('#loader').removeClass('hidden');
                tinyMCE.triggerSave();
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '<?php echo e(url()->current()); ?>',
                    data: {
                        "name": $('#name').val(),
                        "url": $('#url').val(),
                        "league": $('#league').val(),
                        "desc": $('#desc').val(),
                        "file": $('#file').val(),
                        "x1": $('#x1').val(),
                        "x2": $('#x2').val(),
                        "y1": $('#y1').val(),
                        "y2": $('#y2').val(),
                        "hh": $('#hh').val(),
                        "ww": $('#ww').val()
                    }
                }).done(function(response) {
                    console.log('success');
                    console.log(response);

                    $('#name').prop('disabled', false);
                    $('#save').prop('disabled', false);
                    $('#loader').addClass('hidden');
                    if(response['status'] === 'fail') alert(response['text']);
                    else {
                        $('#datatable-responsive tbody').append('<tr class="even pointer"><td class="align-content-center">'+($('#datatable-responsive tbody tr').length + 1).toString()+'</td><td>'+$('#name').val()+'</td><td>'+$('#url').val()+'</td><td>'+$('#league option:selected').text()+'</td><td></td></tr>');
                        $('#name').val('');
                        $('#url').val('');
                        tinyMCE.activeEditor.setContent('');
                        $('#dialog').modal('toggle');
                        alert('Соревнование добавлено');
                    }
                }).fail(function(response) {
                    console.log('fail');
                    $('#name').prop('disabled', false);
                    $('#save').prop('disabled', false);
                    $('#loader').addClass('hidden');
                    alert('Ошибка! ' + response);
                });
            } else alert('Введите наименование');
        });
        $('.select2_single').select2({
            placeholder: "Выберите Лигу",
            allowClear: true,
            dropdownParent: $('#dialog')
        });
        $('#load').on('click', function () {
            newWin = window.open('/home/images/load', 'Загрузка логотипа', 'width=600,height=400,location=no');
        });
        $('#reset_image').on('click', function () {
            $('#uploaded_preview').attr('src','');
            this.hide();
        });
    });
    TableManageButtons.init();
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.main_block'); ?>
    <?php $__env->slot('title'); ?>Перечень соревнований <?php $__env->endSlot(); ?>
    <?php $__env->slot('description'); ?>список всех соревнований <?php $__env->endSlot(); ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-modal">Добавить соревнование</button>
    <div class="ln_solid"></div>
    <div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Новое соревнование</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left">
                    <div class="form-group row text-center hidden" id="loader">
                        <img src="<?php echo e(asset('/images/loading_3.gif')); ?>">
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Соревнование</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" type="text" class="has-feedback-left form-control" name="name" value="" placeholder="введите новое соревнование" required autofocus onkeyup="translit(['name'],'url')">
                            <span class="fa fa-cubes form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="url" class="control-label col-md-3 col-sm-3 col-xs-12">Строка в URL</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="url" type="text" class="has-feedback-left form-control" name="url" value="" disabled required>
                            <span class="fa fa-paper-plane form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Лига</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="league" class="select2_single form-control" style="width: 100%;">
                            <?php $__currentLoopData = $leagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $league): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($league->id); ?>"><?php echo e($league->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Логотип</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="preview" class="center-block" style="width: 100px; height: 100px; overflow: hidden; margin-bottom: 10px;">
                                <img id="uploaded_preview" style="width: 100px; height: 100px;" src="/images/no_image.jpg"/>
                            </div>
                            <input type="hidden" id="upload_path" value="" />
                            <input type="hidden" id="file" name="file" value="" />
                            <input type="hidden" id="x1" name="x1" value="0" />
                            <input type="hidden" id="y1" name="y1" value="0" />
                            <input type="hidden" id="x2" name="x2" value="0" />
                            <input type="hidden" id="y2" name="y2" value="0" />
                            <input type="hidden" id="ww" name="ww" value="0" />
                            <input type="hidden" id="hh" name="hh" value="0" />
                            <center>
                                <button id="load" type="button" class="btn btn-info text-center">Загрузить</button>
                                <button id="reset_image" type="button" class="btn btn-info text-center hidden">Удалить</button>
                            </center>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Описание</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="desc" name="desc"></textarea>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Отмена</button>
                </div>

            </div>
        </div>
    </div>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap responsive-utilities jambo_table bulk_action" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>URL</th>
            <th>Лига</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $tournlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tourn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="even pointer">
                <td class="align-content-center"><?php echo e($loop->index + 1); ?></td>
                <td><?php echo e($tourn->name); ?></td>
                <td><?php echo e($tourn->url); ?></td>
                <td><?php echo e($tourn->league->name); ?></td>
                <td><a onclick="if(confirm('Удалить соревнование?')) window.location.replace('<?php echo e(route('tournlist_delete', $tourn->id)); ?>');" style="cursor: pointer;">удалить</a></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php echo $__env->renderComponent(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>