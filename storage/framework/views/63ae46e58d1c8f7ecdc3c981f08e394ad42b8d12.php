<ul>
    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li item-value="<?php echo e($stage->id); ?>" >233<?php echo e($stage->name); ?></li>
        <?php echo $__env->make('home.tournament.tree', ['stages' => $stage->child], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
