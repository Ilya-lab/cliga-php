<?php $__env->startSection('title'); ?>Календарь соревнований <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?><script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtabs.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxscrollbar.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxlistbox.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcombobox.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownlist.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdropdownbutton.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcalendar.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdatetimeinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtree.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxpanel.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxtooltip.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script type="text/javascript" src="<?php echo e(asset('resources/home/calendar.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<button type="button" class="btn btn-default" id="back">Назад, к соревнованию</button>
<div id="grid" data-back-route="<?php echo e(route('admin_showtournament', $tournament->id)); ?>" data-load-stages="<?php echo e(route('admin_showstages', $tournament->id)); ?>" data-save-route="<?php echo e(route('admin_savematch')); ?>" data-remove-route="<?php echo e(route('admin_removematch')); ?>" data-editview-route="<?php echo e(route('admin_editmatchview')); ?>" data-edit-route="<?php echo e(route('admin_editmatch')); ?>" data-resultview-route="<?php echo e(route('admin_resultmatchview')); ?>" data-result-route="<?php echo e(route('admin_resultmatch')); ?>" data-cancelresult-route="<?php echo e(route('admin_cancelresultmatch')); ?>"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
<div id="messageNotification">
    <div id="message"></div>
</div>

<div class="row m-3">
    <h2><?php echo e($tournament->name); ?></h2>
    <div class="col-md-8 col-sm-4 col-xs-12">
    <?php $__env->startComponent('components.big_block'); ?>
        <?php $__env->slot('title'); ?>Календарь игр <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Предстоящие либо идущие матчи <?php $__env->endSlot(); ?>
        <div id='tabNextMatch'>
            <ul>
            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li item-expanded="true" value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php $maxn = 0; ?>
            <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="m-3">
                <table class="w-100" id="table-<?php echo e($stage->id); ?>">
                    <tr>
                        <th class="text-center hidden-xs">#</th>
                        <th class="text-center">Дата</th>
                        <th class="text-center hidden-xs"></th>
                        <th class="text-center hidden-xs">Арена (площадка)</th>
                        <th class="text-center">Хозяева</th>
                        <th class="text-center"></th>
                        <th class="text-center">Гости</th>
                    </tr>
                    <tbody>
                    <?php $tour = 0;  $mx = $stage->matches->max('number'); if($mx > $maxn) $maxn = $mx; ?>
                    <?php $__currentLoopData = $stage->matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($tour != $game->tour->id): ?>
                        <tr>
                            <td colspan="7" class="text-center"><h5><strong><u><?php echo e($game->tour->shortname); ?></u></strong></h5></td>
                        </tr>
                        <?php $tour = $game->tour->id; ?>
                    <?php endif; ?>
                    <tr class="popoverable border-top <?php if($loop->index % 2 == 0 && $game->status_id == 0): ?> bg-light <?php endif; ?> <?php if($game->status_id == 1): ?> bg-blue-sky <?php endif; ?>" data-match-id="<?php echo e($game->id); ?>" data-match-status="<?php echo e($game->status_id); ?>" data-match-completed=<?php if(!$game->home || !$game->away): ?> "0" <?php else: ?> "1" <?php endif; ?>>
                        <td class="text-center p-2 hidden-xs"><?php echo e($game->number); ?></td>
                        <td class="text-center"><small><?php if($game->datetime): ?><?php echo e(date('d.m.y   H:i', strtotime($game->datetime))); ?><?php endif; ?></small></td>
                        <td class="text-center hidden-xs"><small><?php echo e($game->stage->shortname); ?></small></td>
                        <td class="text-center hidden-xs"><?php echo e($game->place->field->arena->name); ?> <?php if($game->place->field->number > 0): ?> (<?php echo e($game->place->field->number); ?>) <?php endif; ?></td>
                        <td class="text-right"><?php if($game->home): ?><?php echo e($game->home->name); ?> <?php else: ?><small class="red">нет</small><?php endif; ?></td>
                        <td class="text-center">-</td>
                        <td class="text-left"><?php if($game->away): ?><?php echo e($game->away->name); ?><?php else: ?><small class="red">нет</small><?php endif; ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.big_block'); ?>
        <?php $__env->slot('title'); ?>Сыгранные матчи <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Оконченные матчи <?php $__env->endSlot(); ?>
        <div id='tabFinishMatch'>
            <ul>
                <?php $__currentLoopData = $stagesFinish; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li item-expanded="true" value="<?php echo e($stage->id); ?>"><?php echo e($stage->name); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php $maxn = 0; ?>
            <?php $__currentLoopData = $stagesFinish; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="m-3">
                    <table class="w-100" id="tableFinish-<?php echo e($stage->id); ?>">
                        <tr>
                            <th class="text-center hidden-xs">#</th>
                            <th class="text-center">Дата</th>
                            <th class="text-center hidden-xs"></th>
                            <th class="text-center hidden-xs">Арена (площадка)</th>
                            <th class="text-center">Хозяева</th>
                            <th class="text-center"></th>
                            <th class="text-center">Гости</th>
                        </tr>
                        <tbody>
                        <?php $tour = 0;  $mx = $stage->matches->max('number'); if($mx > $maxn) $maxn = $mx; ?>
                        <?php $__currentLoopData = $stage->matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($tour != $game->tour->id): ?>
                                <tr>
                                    <td colspan="7" class="text-center"><h5><strong><u><?php echo e($game->tour->shortname); ?></u></strong></h5></td>
                                </tr>
                                <?php $tour = $game->tour->id; ?>
                            <?php endif; ?>
                            <tr class="popoverable border-top <?php if($loop->index % 2 == 0 && $game->status_id != 4): ?> bg-light <?php endif; ?> <?php if($game->status_id == 4): ?> bg-blue-sky <?php endif; ?>" data-match-id="<?php echo e($game->id); ?>" data-match-status="<?php echo e($game->status_id); ?>" data-match-completed=<?php if(!$game->home || !$game->away): ?> "0" <?php else: ?> "1" <?php endif; ?>>
                                <td class="text-center p-2 hidden-xs"><?php echo e($game->number); ?></td>
                                <td class="text-center"><small><?php if($game->datetime): ?><?php echo e(date('d.m.y   H:i', strtotime($game->datetime))); ?><?php endif; ?></small></td>
                                <td class="text-center hidden-xs"><small><?php echo e($game->stage->shortname); ?></small></td>
                                <td class="text-center hidden-xs"><?php echo e($game->place->field->arena->name); ?> <?php if($game->place->field->number > 0): ?> (<?php echo e($game->place->field->number); ?>) <?php endif; ?></td>
                                <td class="text-right"><?php if($game->home): ?><?php echo e($game->home->name); ?> <?php else: ?><small class="red">нет</small><?php endif; ?></td>
                                <td class="text-center <?php if($game->technicalmissed): ?> red <?php endif; ?>"><?php echo e($game->homescore); ?> : <?php echo e($game->awayscore); ?></td>
                                <td class="text-left"><?php if($game->away): ?><?php echo e($game->away->name); ?><?php else: ?><small class="red">нет</small><?php endif; ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php echo $__env->renderComponent(); ?>
    </div>
    <?php if(!$closed): ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Добавить игру <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Добавить игру к календарю <?php $__env->endSlot(); ?>
        <div>Этап соревнования</div>
        <div id="dropDownButton" class="position-sticky">
            <div id="level" class="position-sticky" style="border: none;">

            </div>
        </div>
        <div style="padding-top: 20px;">Номер матча</div>
        <div id="number" class="position-sticky"></div>
        <div style="padding-top: 20px;">Дата и время матча</div>
        <div id="datetime" class="position-sticky"></div>
        <div style="padding-top: 20px;">Тур (стадия) матча</div>
        <select id="tour" class="position-sticky">
            <?php $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tour->id); ?>"><?php echo e($tour->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div style="padding-top: 20px;">Арена (площадка)</div>
        <select id="arena" class="position-sticky">
            <option value="0">Не выбрано</option>
            <?php $__currentLoopData = $arenas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arena): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($arena->field && $arena->field->arena): ?>
            <option value="<?php echo e($arena->id); ?>"><?php echo e($arena->field->arena->name); ?> (<?php echo e($arena->field->name); ?>)</option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div style="padding-top: 20px;">Команда хозяев</div>
        <select id="home" class="position-sticky">
            <option value="0">Не выбрано</option>
            <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?> (<?php echo e($team->city); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div style="padding-top: 20px;">Команда гостей</div>
        <select id="away" class="position-sticky">
            <option value="0">Не выбрано</option>
            <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?> (<?php echo e($team->city); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div style="padding-top: 20px;">Следующий матч сдвинуть на минут</div>
        <div id="nextmatch" class="position-sticky"></div>
        <div class="text-center"><button type="submit" id="save_button" class="btn btn-primary navbar-btn">Добавить</button></div>
    <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>

</div>
<input id="closed" type="hidden" value=" <?php echo e($closed ? 1 : 0); ?>">
<input id="tournament-id" type="hidden" value="<?php echo e($tournament->id); ?>">
<input id="max-number-match" type="hidden" value="<?php echo e($maxn); ?>">
<div id="ajax"></div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>