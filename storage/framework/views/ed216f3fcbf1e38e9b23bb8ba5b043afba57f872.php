<?php $__env->startSection('title'); ?>Новости <?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.main_block'); ?>
    <?php $__env->slot('title'); ?>Новости <?php $__env->endSlot(); ?>
    <?php $__env->slot('description'); ?>Новости турниров <?php $__env->endSlot(); ?>
    <router-view name="newsIndex"></router-view>
    <router-view></router-view>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>