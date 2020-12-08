<?php if($tournament): ?>
    <div id="noqbot-upcomingmatch-slider" class="noqbot-upcomingmatch-slider noqbot-upcomingmatch">
        <div class="noqbot-pointtable-title-full">
            <div id="matches_name" class="noqbot-box"><?php echo e($tournament->name); ?></div>
        </div>
        <div class="swiper-wrapper">
            <?php $__empty_1 = true; $__currentLoopData = /*$matches->sortByDesc('datetime')*/ $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($match->status_id != 2): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="swiper-slide">
                    <div class="noqbot-ticket">
                        <time class="noqbot-matchdate" datetime="<?php echo e($match->datetime); ?>"><?php echo e(date('d', strtotime($match->datetime))); ?><span><?php echo e(Matches::monthName(date('n', strtotime($match->datetime)))); ?></span></time>
                        <div class="noqbot-matchdetail">
                            <span class="noqbot-theme-tag"><?php echo e($match->tour->name); ?></span>
                            <h4><?php echo e($match->home->name); ?><span> - </span><?php echo e($match->away->name); ?></h4>
                            <ul class="noqbot-matchmetadata">
                                <li><address><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i><?php echo e(date('H:m', strtotime($match->datetime))); ?></address></li>
                                <li><address><i id="noqbot-news-clock-icon" class="fa fa-info-circle"></i><?php echo e($match->place->field->arena->name); ?>: <?php echo e($match->place->field->name); ?></address></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div>Нет предстоящих матчей в соревновании</div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
