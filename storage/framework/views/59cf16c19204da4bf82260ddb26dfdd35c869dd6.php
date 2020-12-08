<?php $__env->startSection('title'); ?>Настройки соревнования - «<?php echo e($tournament->name); ?>» <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxswitchbutton.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script type="text/javascript" src="<?php echo e(asset('resources/home/settings.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <button type="button" class="btn btn-default" id="back">Назад, к соревнованию</button>
    <div id="grid" data-back-route="<?php echo e(route('admin_showtournament', $tournament->id)); ?>"></div>
    <div id="loader"></div>
    <div class="ln_solid"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>
    <div class="row m-3">
        <?php $__env->startComponent('components.box_block'); ?>
            <?php $__env->slot('title'); ?>Формат <?php $__env->endSlot(); ?>
            <?php $__env->slot('description'); ?> Формат проведения соревнования <?php $__env->endSlot(); ?>
            <div id="ssettingsbox">
                123
            </div>
        <?php echo $__env->renderComponent(); ?>

        <?php $__env->startComponent('components.box_block'); ?>
            <?php $__env->slot('title'); ?>Настройки <?php $__env->endSlot(); ?>
            <?php $__env->slot('description'); ?> Настройки соревнования <?php $__env->endSlot(); ?>
            <div id="settingsbox">
                <?php echo $__env->make('home.tournament.ajax_tournsettings_view', ['settings' => $settings, 'roles' => $roles, 'tournament' => $tournament ], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        <?php echo $__env->renderComponent(); ?>

        <?php if($roles->contains(1)): ?>
        <?php $__env->startComponent('components.box_block'); ?>
            <?php $__env->slot('title'); ?>Права доступа <?php $__env->endSlot(); ?>
            <?php $__env->slot('description'); ?> Пользователи, допущенные к соревнованию <?php $__env->endSlot(); ?>
            123
        <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>
    </div>
    <div id="ajax"></div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>