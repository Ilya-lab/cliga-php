<?php $__env->startSection('title'); ?>Турнир - «<?php echo e($tournament->name); ?>» <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtabs.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtree.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.main_block'); ?>
        <?php $__env->slot('title'); ?>Турнир <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?><?php echo e($tournament->name); ?> <?php $__env->endSlot(); ?>
            <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Заявки <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?><?php echo e(route('admin_showbids', $tournament->id)); ?> <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-book <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Список заявок <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
            <?php endif; ?>

        <?php if($roles->contains(1) || $roles->contains(2)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Команды <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?><?php echo e(route('admin_showbidteams', $tournament->id)); ?> <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-group <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Действия над командой <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Календарь <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?><?php echo e(route('admin_calendar', $tournament->id)); ?> <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-calendar <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Расписание матчей <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Таблицы <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?>/ <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-th-list <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Корректировка таблиц <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Дисквалификации <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?>/ <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-stop <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Дисквалификации участников <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if($roles->contains(1)): ?>
            <?php $__env->startComponent('components.small_block'); ?>
                <?php $__env->slot('title'); ?>Настройки <?php $__env->endSlot(); ?>
                <?php $__env->slot('url'); ?>/ <?php $__env->endSlot(); ?>
                <?php $__env->slot('icon'); ?>fa-cogs <?php $__env->endSlot(); ?>
                <?php $__env->slot('description'); ?>Установки соревнования <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row m-3">
        <div id="grid" data-load-stages="<?php echo e(route('admin_showstages', $tournament->id)); ?>"></div>
        <div class="col-md-8 col-sm-4 col-xs-12">
    <?php $__env->startComponent('components.big_block'); ?>
        <?php $__env->slot('title'); ?>Формат соревнования <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Этапы турнира <?php $__env->endSlot(); ?>
        <div id='tabStage'>
            <ul>
                <li>Структура турнира</li>
                <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="m-3">
                <div id="level" class="position-sticky"></div>
            </div>
            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-3">
                    <?php if($stage->levels_id == 3): ?>
                        <?php if($stage->table->count() > 0): ?>
                            <table class="w-100">
                                <tr>
                                    <th class="text-center w-5">#</th>
                                    <th class="text-center w-auto">Команда</th>
                                    <th class="text-center w-10 hidden-xs">И</th>
                                    <th class="text-center w-10 hidden-xs">В</th>
                                    <th class="text-center w-10 hidden-xs">Н</th>
                                    <th class="text-center w-10 hidden-xs">П</th>
                                    <th class="text-center w-10 hidden-xs">Мячи</th>
                                    <th class="text-center w-10">О</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $stage->table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?>">
                                        <td class="text-center p-2"><?php if($team->place > 0): ?> <?php echo e($team->place); ?> <?php endif; ?></td>
                                        <td class="text-left"><?php echo e($team->team->name); ?> (<?php echo e($team->team->city); ?>)</td>
                                        <td class="text-center hidden-xs"><?php echo e($team->win + $team->los + $team->nic); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->win); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->nic); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->los); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->zab); ?> - <?php echo e($team->prop); ?></td>
                                        <td class="text-center"><?php echo e($team->points); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <?php $__currentLoopData = $stage->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <h2><?php echo e($group->name); ?></h2>
                            <table class="w-100">
                                <tr>
                                    <th class="text-center w-5">#</th>
                                    <th class="text-center w-auto">Команда</th>
                                    <th class="text-center w-10 hidden-xs">И</th>
                                    <th class="text-center w-10 hidden-xs">В</th>
                                    <th class="text-center w-10 hidden-xs">Н</th>
                                    <th class="text-center w-10 hidden-xs">П</th>
                                    <th class="text-center w-10 hidden-xs">Мячи</th>
                                    <th class="text-center w-10">О</th>
                                </tr>
                                <tbody>
                                <?php $__currentLoopData = $group->table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-top <?php if($loop->index % 2 == 0): ?> bg-light <?php endif; ?>">
                                        <td class="text-center p-2"><?php if($team->place > 0): ?> <?php echo e($team->place); ?> <?php endif; ?></td>
                                        <td class="text-left"><?php echo e($team->team->name); ?> (<?php echo e($team->team->city); ?>)</td>
                                        <td class="text-center hidden-xs"><?php echo e($team->win + $team->los + $team->nic); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->win); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->nic); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->los); ?></td>
                                        <td class="text-center hidden-xs"><?php echo e($team->zab); ?> - <?php echo e($team->prop); ?></td>
                                        <td class="text-center"><?php echo e($team->points); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php echo $__env->renderComponent(); ?>
        </div>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Календарь матчей <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Сортировка по турам <?php $__env->endSlot(); ?>
            <table class="w-100" id="tableFinish-<?php echo e($stage->id); ?>">
                <tr>
                    <th class="text-center">Дата</th>
                    <th class="text-center hidden-xs"></th>
                    <th class="text-center">Хозяева</th>
                    <th class="text-center"></th>
                    <th class="text-center">Гости</th>
                </tr>
                <tbody>
                <?php $tour = 0; ?>
                <?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($tour != $game->tour->id): ?>
                        <tr>
                            <td colspan="7" class="text-center"><h5><strong><u><?php echo e($game->tour->shortname); ?></u></strong></h5></td>
                        </tr>
                        <?php $tour = $game->tour->id; ?>
                    <?php endif; ?>
                    <tr class="popoverable border-top <?php if($loop->index % 2 == 0 && $game->status_id != 4): ?> bg-light <?php endif; ?> <?php if($game->status_id == 4): ?> bg-blue-sky <?php endif; ?>" data-match-id="<?php echo e($game->id); ?>" data-match-status="<?php echo e($game->status_id); ?>">
                        <td class="text-center"><small><?php if($game->datetime): ?><?php echo e(date('d.m.y   H:i', strtotime($game->datetime))); ?><?php endif; ?></small></td>
                        <td class="text-center hidden-xs"><small><?php echo e($game->stage->shortname); ?></small></td>
                        <td class="text-right"><?php if($game->home): ?><?php echo e($game->home->name); ?> <?php else: ?><small class="red">нет</small><?php endif; ?></td>
                        <td class="text-center <?php if($game->technicalmissed): ?> red <?php endif; ?>"><?php echo e($game->homescore); ?> : <?php echo e($game->awayscore); ?></td>
                        <td class="text-left"><?php if($game->away): ?><?php echo e($game->away->name); ?><?php else: ?><small class="red">нет</small><?php endif; ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
    <?php echo $__env->renderComponent(); ?>
    </div>
    <script>
        $(document).ready(function () {
            $('#tabStage').jqxTabs({width: '100%', position: 'top'})
            var source = {
                datatype: "json",
                type: "GET",
                datafields: [
                    { name: 'id' },
                    { name: 'parent_id' },
                    { name: 'levels_id' },
                    { name: 'name' },
                    { name: 'shortname'},
                    { name: 'priority' },
                ],
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#grid').data('loadStages'),
                async: false,
            }
            var dataAdapter = new $.jqx.dataAdapter(source, {
                beforeLoadComplete: function (records) {
                    for(var i=0; i<records.length; i++) {
                        if(i==0) records[i]['selected'] = true
                        if(records[i]['parent_id'] === null) records[i]['parent_id'] = 0;
                        records[i]['expanded'] = true
                    }
                    return records;
                }
            })
            dataAdapter.dataBind()
            var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{ name: 'name', map: 'label'},{ name: 'id', map: 'value'}])
            $('#level').jqxTree({ source: records, width: '99%', theme: 'bootstrap'})
        })
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>