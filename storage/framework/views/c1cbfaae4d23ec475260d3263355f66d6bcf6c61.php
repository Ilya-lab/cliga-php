<?php $__env->startSection('title'); ?>Все новости<?php $__env->stopSection(); ?>
<?php $__env->startSection('desc'); ?>Все новости Корпоративной лиги<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($nn->title); ?> <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo e(var_dump($news)); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsfooter'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.general', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>