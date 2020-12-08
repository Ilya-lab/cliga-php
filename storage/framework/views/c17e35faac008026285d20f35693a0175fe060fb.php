<?php $__env->startSection('title'); ?>Участники <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?><script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxgrid.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxgrid.selection.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxgrid.pager.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxgrid.columnsresize.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxwindow.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdatetimeinput.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcalendar.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtooltip.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxvalidator.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/translite.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/other.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/tinymce/tinymce.min.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/toggle/js/bootstrap4-toggle.min.js').'?v='.config('app.version')); ?>"></script>
    <!-- datetimepicker -->
    <script src="<?php echo e(asset('js/datetimepicker/moment-with-locales.min.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/datetimepicker/bootstrap-datetimepicker.min.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?><link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<link href="<?php echo e(asset('js/toggle/css/bootstrap4-toggle.min.css').'?v='.config('app.version')); ?>" rel="stylesheet">
<!-- datetimepicker -->
<link href="<?php echo e(asset('css/datetimepicker/bootstrap-datetimepicker.min.css').'?v='.config('app.version')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
    <script type="text/javascript" src="<?php echo e(asset('resources/home/players.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_block'); ?>
        <?php $__env->slot('title'); ?>Участники <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Участники соревнований <?php $__env->endSlot(); ?>
        <button type="button" class="btn btn-primary player-add" data-toggle="modal" data-target=".bs-modal">Добавить участника</button>
        <div class="ln_solid"></div>
        <div id="grid" data-load-route="<?php echo e(route('person_ajaxload')); ?>" data-save-route="<?php echo e(route('person_save')); ?>" data-show-route="<?php echo e(url('/home/person/')); ?>" data-update-route="<?php echo e(url('/home/person/')); ?>"></div>
        <div id="messageNotification">
            <div id="message"></div>
        </div>
        <div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Участник</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formVal" class="form-horizontal form-label-left">
                    <div class="form-group row text-center hidden" id="loader">
                        <img src="<?php echo e(asset('/images/loading_3.gif')); ?>">
                    </div>
                    <div class="form-group row">
                        <label for="family" class="control-label col-md-3 col-sm-3 col-xs-12">Фамилия</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="family" type="text" class="has-feedback-left form-control" name="family" value="" placeholder="введите фамилию" required autofocus onkeyup="translit(['family','name','surname'],'url')">
                            <span class="fa fa-male form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Имя</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" type="text" class="has-feedback-left form-control" name="name" value="" placeholder="введите имя" required autofocus onkeyup="translit(['family','name','surname'],'url')">
                            <span class="fa fa-male form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="surname" class="control-label col-md-3 col-sm-3 col-xs-12">Отчество</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="surname" type="text" class="has-feedback-left form-control" name="surname" value="" placeholder="введите отчество" required autofocus onkeyup="translit(['family','name','surname'],'url')">
                            <span class="fa fa-male form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Дата рождения</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="birthdate" class="has-feedback-left form-control" name="birthdate" value="" placeholder="введите дату рождения" required>
                            <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">Фотография</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!--<div id="image_preview"><div class="closed hidden -hand-pointer-o"></div><img src="/images/no_image.jpg"></div>-->
                            <div id="preview" style="width: 100px; height: 100px; overflow: hidden; margin-bottom: 10px; float: left">
                                <div id="closed" class="closed hidden" style="left: 84px;"></div>
                                <img id="uploaded_preview" style="width: 100px; height: 100px; cursor: pointer;" src="/images/no_image.jpg"/>
                            </div>
                            <input type="hidden" id="upload_path" value="" />
                            <input type="hidden" id="file" name="file" value="" />
                            <input type="hidden" id="x1" name="x1" value="0" />
                            <input type="hidden" id="y1" name="y1" value="0" />
                            <input type="hidden" id="x2" name="x2" value="0" />
                            <input type="hidden" id="y2" name="y2" value="0" />
                            <input type="hidden" id="ww" name="ww" value="0" />
                            <input type="hidden" id="hh" name="hh" value="0" />

                            <div id="photo_box" class="hidden">
                            <select id="photo" name="photo">
                                <option value="0" >/images/no_image.jpg</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">Дополнительно</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" id="other" data-toggle="toggle" data-on="Показано" data-off="Убрано" data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                        </div>
                    </div>
                    <div id="otherbox" class="hidden">
                        <div class="form-group row">
                            <label for="url" class="control-label col-md-3 col-sm-3 col-xs-12">URL</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="url" type="text" class="has-feedback-left form-control" name="url" value="" disabled>
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Пол</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="sex" name="sex" checked data-toggle="toggle" data-on="Муж." data-off="Жен." data-onstyle="primary" data-offstyle="danger" data-width="90" data-height="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">Гражданство</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="country" class="select2_single form-control" style="width: 100%;">
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" type="text" class="has-feedback-left form-control" name="email" value="" placeholder="введите email">
                                <span class="fa fa-send form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">Телефон</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="phone" type="text" class="has-feedback-left form-control" name="phone" value="" placeholder="введите телефон">
                                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea id="comment" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                    </div>
                    <div class="modal-footer">
                        <div class="left">
                            <input type="checkbox" id="active" name="active" checked data-toggle="toggle" data-on="Активен" data-off="Не активен" data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                        </div>
                        <input type="hidden" id="file_name" value="">
                        <input type="hidden" id="person-id" value="0">
                        <button type="button" id="save" class="btn btn-success">Сохранить</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
                    </div>
                </div>>
            </div>
        </div>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>