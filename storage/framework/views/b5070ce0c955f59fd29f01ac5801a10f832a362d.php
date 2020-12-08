<?php $__env->startSection('title'); ?>Команда "<?php echo e($team->name); ?>" (<?php echo e($team->city); ?> в заявке на <?php echo e($tournament->name); ?> <?php $__env->stopSection(); ?>

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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
    <script type="text/javascript" src="<?php echo e(asset('resources/home/bidteam.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <button type="button" class="btn btn-default" id="back">Назад, в соревнование</button>
    <div class="ln_solid"></div>
    <div id="grid" data-back-route="<?php echo e(route('admin_showbidteams', $tournament->id)); ?>"></div>
    <div id="messageNotification">
        <div id="message"></div>
    </div>
    <div class="row">
        <div class="image">
            <?php if(isset($team->logo)): ?>
                <?php $__currentLoopData = $team->logo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($thumb->thumb_id == 5): ?>
                        <div class="left"><img src="<?php echo e($thumb->filename); ?>" alt="логотип <?php echo e($team->name); ?>" class="mr-5" /></div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <h1><?php echo e($team->name); ?> (<?php echo e($team->city); ?>)</h1>
    </div>

    <div class="row">
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Заявочные окна <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> <?php $__env->endSlot(); ?>
       <table class="w-100">
           <tr>
               <th align="center">#</th>
               <th align="center">Наименование</th>
               <th align="center">Начало</th>
               <th align="center">Окончание</th>
           </tr>
           <tbody>
           <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                   <td class="text-center"><?php echo e($loop->index + 1); ?>.</td>
                   <td class="text-left p-3"><a href="<?php echo e(route('admin_showbidteam', [$team->id, $bid->id])); ?>"><?php echo e($bid->name); ?></a></td>
                   <td class="text-center"><?php echo e(date('d.m.Y', strtotime($bid->start))); ?></td>
                   <td class="text-center"><?php echo e(date('d.m.Y', strtotime($bid->finish))); ?></td>
               </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </tbody>
       </table>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Игроки <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Заявленные игроки <?php $__env->endSlot(); ?>
            <table class="w-100" id="table-players">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php if($player->number > 0): ?><?php echo e($player->number); ?><?php endif; ?></td>
                        <td class="text-left p-3"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family); ?> <?php echo e($player->name); ?> <?php if($player->captain->id > 0): ?> (<?php echo e($player->captain->shortname); ?>)<?php endif; ?></a></td>
                        <td class="text-center"><?php echo e($player->position->name); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($players) > 0): ?>
                <p>Итого в составе - <strong class="red" id="playercount"><?php echo e(count($players)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Администрация <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Заявленные представители команды <?php $__env->endSlot(); ?>
            <table class="w-100" id="table-coaches">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php echo e($loop->index + 1); ?>.</td>
                        <td class="text-left p-3"><a href="/"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family); ?> <?php echo e($player->name); ?></a></a></td>
                        <td class="text-center"><?php echo e($player->post->name); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($admins) > 0): ?>
                <p>Итого в составе - <strong class="red" id="coachcount"><?php echo e(count($admins)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Стадион <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Заявленный стадион команды <?php $__env->endSlot(); ?>
        Пока не реализовано
    <?php echo $__env->renderComponent(); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>