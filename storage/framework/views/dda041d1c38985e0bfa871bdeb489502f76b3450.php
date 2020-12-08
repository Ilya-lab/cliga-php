<?php $__env->startSection('title'); ?>Все соревнования<?php $__env->stopSection(); ?>
<?php $__env->startSection('desc'); ?>Все новости Корпоративной лиги<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2> Все соревнования</h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsfooter'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.general', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>