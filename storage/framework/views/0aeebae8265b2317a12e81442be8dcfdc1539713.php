<div class="m-3">
    <table class="w-100">
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Игрок</th>
            <th class="text-center">Позиция</th>
        </tr>
        <tbody>
        <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="popoverable border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?> " data-player-id="<?php echo e($player->player_id); ?>" data-team-id="<?php echo e($player->team_id); ?>" data-opponent-id="<?php echo e($opponent_id); ?>" data-player-name="<?php echo e($player->number); ?>. <?php echo e($player->family . ' ' . $player->name); ?>" style="cursor: pointer" title="Действия в матче" <?php if($player->is_goalkeeper ): ?> data-gk="1" <?php else: ?> data-gk="0" <?php endif; ?>>
                <td class="text-center p-2"  <?php if($player->is_goalkeeper ): ?> style="font-weight: bold;" <?php endif; ?>><?php echo e($player->number); ?></td>
                <td class="text-left" <?php if($player->is_goalkeeper ): ?> style="font-weight: bold;" <?php endif; ?>><?php echo e($player->family . ' ' . $player->name); ?></td>
                <td class="text-center"  <?php if($player->is_goalkeeper ): ?> style="font-weight: bold;" <?php endif; ?>><?php if($player->is_goalkeeper ): ?> вр <?php else: ?> <?php echo e($player->position_shortname); ?> <?php endif; ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<p>Итого заявлено на игру: <strong class="red"><?php echo e($players->count()); ?></strong></p>
<script>
    memberPlayers[<?php echo e($team_id); ?>] = <?php echo $players; ?>

    try {
        popover()
    } catch (error) {
        //console.log('Функция не вызвана')
    }
</script>
