<?php
    $final = false;
?>

<?php $__currentLoopData = $table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($loop->count > 1): ?><h3 class="noqbot-pointtable-title"><?php echo e($stage['name']); ?></h3><?php endif; ?>
    <?php if($stage['type'] == 'table'): ?>
        <div class="swiper-slide">
            <div class="noqbot-pointtable-title">
                <div class="noqbot-box"></div>
                <div class="noqbot-box">КОМАНДА</div>
                <?php if($tournament->status_id != 2): ?>
                    <div class="noqbot-box">И</div>
                    <div class="noqbot-box">В</div>
                    <div class="noqbot-box">Н</div>
                    <div class="noqbot-box">П</div>
                    <div class="noqbot-box">МЯЧИ</div>
                    <div class="noqbot-box">О</div>
                <?php endif; ?>
            </div>
        </div>
        <div id="noqbot-pointstable-slider" class="noqbot-pointstable-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <?php $__currentLoopData = $stage['table']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="noqbot-pointtable">
                            <div class="noqbot-box"><?php if($tt['place'] > 0): ?> <?php echo e($tt['place']); ?> <?php endif; ?></div>
                            <div class="noqbot-box"><?php echo e($tt['name']); ?></div>
                            <?php if($tournament->status_id != 2): ?>
                                <div class="noqbot-box"><?php echo e($tt['games']); ?></div>
                                <div class="noqbot-box"><?php echo e($tt['win']); ?></div>
                                <div class="noqbot-box"><?php echo e($tt['nic']); ?></div>
                                <div class="noqbot-box"><?php echo e($tt['los']); ?></div>
                                <div class="noqbot-box"><?php echo e($tt['zab']); ?>-<?php echo e($tt['prop']); ?></div>
                                <div class="noqbot-box"><?php echo e($tt['points']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php $__currentLoopData = $stage['table']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="noqbot-pointtable">
                <div class="noqbot-box"><?php if($tt['place'] > 0): ?> <?php echo e($tt['place']); ?> <?php endif; ?></div>
                <div class="noqbot-box"><?php echo e($tt['name']); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
