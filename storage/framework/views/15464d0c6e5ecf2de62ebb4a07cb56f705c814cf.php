<div class="m-3">
    <table class="w-100">
        <tr>
            <th class="text-center"></th>
            <th class="text-center">Мин</th>
            <th class="text-center">Игрок</th>
            <th class="text-center"></th>
        </tr>
        <tbody>
        <?php
        $homeScore = 0; $awayScore = 0;
        ?>
        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            if ($event->team_id == $match->home_id) {
                 if ($event->event_id >= 4 && $event->event_id <= 5) $homeScore++;
                 elseif ($event->event_id == 6) $awayScore++;
            } elseif ($event->team_id == $match->away_id) {
                if ($event->event_id >= 4 && $event->event_id <= 5) $awayScore++;
                elseif ($event->event_id == 6) $homeScore++;
            }
            ?>
            <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?> " data-event-id="<?php echo e($event->id); ?>">
                <td class="text-center p-2"><?php if($event->event_id == 4): ?><img src="<?php echo e(asset('/images/icons/ball_16.png')); ?>" alt="<?php echo e($event->eventname); ?>"><?php elseif($event->event_id == 5): ?> <img src="<?php echo e(asset('/images/icons/penaltyball.png')); ?>" alt="<?php echo e($event->eventname); ?>"><?php elseif($event->event_id == 6): ?> <img src="<?php echo e(asset('/images/icons/agball.png')); ?>" alt="<?php echo e($event->eventname); ?>"> <?php elseif($event->event_id == 1): ?> <img src="<?php echo e(asset('/images/icons/yellow.png')); ?>" alt="<?php echo e($event->eventname); ?>"> <?php elseif($event->event_id == 2): ?> <img src="<?php echo e(asset('/images/icons/yellow2.png')); ?>" alt="<?php echo e($event->eventname); ?>"> <?php elseif($event->event_id == 3): ?> <img src="<?php echo e(asset('/images/icons/red.png')); ?>" alt="<?php echo e($event->eventname); ?>"> <?php endif; ?></td>
                <td class="text-center p-2"><strong><?php echo e($event->minute); ?>'</strong></td>
                <?php if($event->event_id >= 4 && $event->event_id <= 6): ?>
                <td class="text-left"><?php echo e($event->number); ?> - <?php echo e($event->family . ' ' . $event->name); ?> <?php if($event->team_id == $match->home_id): ?> <small class="blue">(<?php echo e($match->home->name); ?>)</small> <?php endif; ?> <?php if($event->team_id == $match->away_id): ?> <small class="green">(<?php echo e($match->away->name); ?>)</small> <?php endif; ?><br><small><?php if($event->assist_id > 0): ?> с пер. <?php echo e($event->assist_number); ?> - <?php echo e($event->assist_family . ' ' . $event->assist_name); ?><?php if($event->opponent_id > 0): ?>, <?php endif; ?> <?php endif; ?> <?php if($event->opponent_id > 0): ?> вр. <?php echo e($event->gk_number); ?> - <?php echo e($event->gk_family . ' ' . $event->gk_name); ?> <?php endif; ?></small></td>
                <?php else: ?>
                <td class="text-left"><?php echo e($event->number); ?> - <?php echo e($event->family . ' ' . $event->name); ?> <?php if($event->team_id == $match->home_id): ?> <small class="blue">(<?php echo e($match->home->name); ?>)</small> <?php endif; ?> <?php if($event->team_id == $match->away_id): ?> <small class="green">(<?php echo e($match->away->name); ?>)</small> <?php endif; ?><br>
                </td>
                <?php endif; ?>
                <td class="text-center remove"><i class="fa fa-close" title="Удалить событие"></i></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <p>Счёт по голам: <span class="red"><?php echo e($homeScore); ?> : <?php echo e($awayScore); ?></span></p>
</div>
