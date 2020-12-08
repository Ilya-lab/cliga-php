<?php $__env->startSection('title'); ?>Заявочные окна <?php $__env->stopSection(); ?>

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
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxvalidator.js').'?v='.config('app.version')); ?>"></script>
    <!-- datetimepicker -->
    <script src="<?php echo e(asset('js/datetimepicker/moment-with-locales.min.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/datetimepicker/bootstrap-datetimepicker.min.js').'?v='.config('app.version')); ?>"></script>
    <script src="<?php echo e(asset('js/toggle/js/bootstrap4-toggle.min.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
    <link href="<?php echo e(asset('js/toggle/css/bootstrap4-toggle.min.css').'?v='.config('app.version')); ?>" rel="stylesheet">
    <!-- datetimepicker -->
    <link href="<?php echo e(asset('css/datetimepicker/bootstrap-datetimepicker.min.css').'?v='.config('app.version')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
    <script type="text/javascript" src="<?php echo e(asset('resources/home/bids.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button>
    <?php if($tournament->status_id <= 1): ?><button type="button" class="btn btn-primary player-add" data-toggle="modal" data-target=".bs-modal">Добавить заявочное окно</button><?php endif; ?>
    <div class="ln_solid"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>
    <div class="modal fade bs-modal" id="dialog" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Заявочное окно</h4>
                </div>
                <div class="modal-body">
                    <form id="formVal" class="form-horizontal form-label-left">
                        <div class="form-group row text-center hidden" id="loader">
                            <img src="<?php echo e(asset('/images/loading_3.gif')); ?>">
                        </div>
                        <div class="form-group row">
                            <label for="bidname" class="control-label col-md-3 col-sm-3 col-xs-12">Наименование</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="bidname" type="text" class="has-feedback-left form-control" name="bidname" value="" placeholder="введите наименование заявочного окна" required autofocus>
                                <span class="fa fa-file-word-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start" class="control-label col-md-3 col-sm-3 col-xs-12">Начало периода</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="start" class="has-feedback-left form-control" name="start" value="" placeholder="введите дату начало периода" required>
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="finish" class="control-label col-md-3 col-sm-3 col-xs-12">Окончание периода</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="finish" class="has-feedback-left form-control" name="finish" value="" placeholder="введите дату окончания периода" required>
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="teams" class="control-label col-md-3 col-sm-3 col-xs-12">Команды</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="teams" data-toggle="toggle" data-on="Вкл." data-off="Выкл." data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="arenas" class="control-label col-md-3 col-sm-3 col-xs-12">Стадионы</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="arenas" data-toggle="toggle" data-on="Вкл." data-off="Выкл." data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="referees" class="control-label col-md-3 col-sm-3 col-xs-12">Судьи</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="referees" data-toggle="toggle" data-on="Вкл." data-off="Выкл." data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="admins" class="control-label col-md-3 col-sm-3 col-xs-12">Штабы команд</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="admins" data-toggle="toggle" data-on="Вкл." data-off="Выкл." data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="players" class="control-label col-md-3 col-sm-3 col-xs-12">Игроки</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="players" data-toggle="toggle" data-on="Вкл." data-off="Выкл." data-onstyle="success" data-offstyle="danger" data-width="120" data-height="30" checked>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="bid-id" value="0">
                    <input type="hidden" id="tournament-id" value="<?php echo e($tournament->id); ?>">
                    <button type="button" id="save" class="btn btn-success">Сохранить</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->startComponent('components.main_block'); ?>
        <?php $__env->slot('title'); ?>Заявки <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Заявки на соревнование - <?php echo e($tournament->name); ?><?php $__env->endSlot(); ?>
        <div id="grid" data-load-route="<?php echo e(route('bid_ajaxload', $tournament->id)); ?>" data-save-route="<?php echo e(route('bid_save', $tournament->id)); ?>" data-back-route="<?php echo e(route('admin_showtournament', $tournament->id)); ?>"  data-show-route="<?php echo e(url('/home/person/')); ?>" data-update-route="<?php echo e(url('/home/person/')); ?>"></div>
        <div class="ln_solid"></div>
        <div class="row">
        <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.box_block'); ?>
                <?php $__env->slot('title'); ?>Команды <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Заявленные команды <?php $__env->endSlot(); ?>
                3234232
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1) || $roles->contains(2) ): ?>
            <?php $__env->startComponent('components.box_block'); ?>
                <?php $__env->slot('title'); ?>Стадионы <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Заявленные стадионы <?php $__env->endSlot(); ?>
                3234232
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1) || $roles->contains(2) ): ?>
            <?php $__env->startComponent('components.box_block'); ?>
                <?php $__env->slot('title'); ?>Судьи <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Заявленные судьи <?php $__env->endSlot(); ?>
                3234232
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>
        </div>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>