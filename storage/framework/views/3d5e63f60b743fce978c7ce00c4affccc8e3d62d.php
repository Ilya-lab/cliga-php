<?php $__env->startSection('title'); ?>Заявочное окно «<?php echo e($bid->name); ?>» команды «<?php echo e($team->name); ?>» (<?php echo e($team->city); ?>) <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?><script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxdata.js').'?v='.config('app.version')); ?>"></script>
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
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
<script type="text/javascript" src="<?php echo e(asset('resources/home/bidplayers.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<button type="button" class="btn btn-default" id="back">Назад, к команде</button>
<div id="grid" data-back-route="<?php echo e(route('admin_showteam', $team->id)); ?>"  data-load-route="<?php echo e(route('person_ajaxbidload')); ?>" data-path="" data-back-route="<?php echo e(route('admin_showteam', $team->id)); ?>" data-save-player="<?php echo e(route("admin_savebidteamperson", [$team->id, $bid->id])); ?>" data-remove-player="<?php echo e(route("admin_removebidteamperson", [$team->id, $bid->id])); ?>" data-cancelremove-player="<?php echo e(route("admin_cancelremovebidteamperson", [$team->id, $bid->id])); ?>"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
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
<div class="row m-3">
    <h2>Заявочное окно «<?php echo e($bid->name); ?>». Команда «<?php echo e($team->name); ?>» (<?php echo e($team->city); ?>) в турнире «<?php echo e($tournament->name); ?>».</h2>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Текущий состав <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> <?php $__env->endSlot(); ?>
        <h3>Игроки</h3>
        <table class="w-100" id="table-players">
            <tr>
                <th align="center">#</th>
                <th align="center">Игрок</th>
                <th align="center">Позиция</th>
                <?php if($tournament->status_id <= 1): ?><th align="center"></th><?php endif; ?>
            </tr>
            <tbody>
            <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                <td class="text-center"><?php if($player->number > 0): ?><?php echo e($player->number); ?><?php endif; ?></td>
                <td class="text-left p-3"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family); ?> <?php echo e($player->name); ?> <?php if($player->captain->id > 0): ?> (<?php echo e($player->captain->shortname); ?>)<?php endif; ?></a></td>
                <td class="text-center"><?php echo e($player->position->shortname); ?></td>
                <?php if($tournament->status_id <= 1): ?><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td><?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php if(count($players) > 0): ?>
        <p>Итого в составе - <strong class="red" id="playercount"><?php echo e(count($players)); ?></strong></p>
        <?php else: ?>
            <p class="text-center">нет</p>
        <?php endif; ?>
        <div class="x_title"></div>
        <h3>Персонал</h3>
            <table class="w-100" id="table-coaches">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                    <?php if($tournament->status_id <= 1): ?><th align="center"></th><?php endif; ?>
                </tr>
                <tbody>
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php echo e($loop->index + 1); ?>.</td>
                        <td class="text-left p-3"><a href="/"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family); ?> <?php echo e($player->name); ?></a></a></td>
                        <td class="text-center"><?php echo e($player->post->name); ?></td>
                        <?php if($tournament->status_id <= 1): ?><td class="text-center remove"><i class="fa fa-close" title="Удалить из команды"></i></td><?php endif; ?>
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

    <?php if($tournament->status_id <= 1): ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Заявить участника <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Добавление в заявочный лист <?php $__env->endSlot(); ?>
            <div>Тип заявки</div>
            <select id="typebid" name="typebid" style="width: 100%;">
                <option value="0" >Игрок</option>
                <option value="1" >Администрация и тренеры</option>
            </select>
            <div style="padding-top: 20px;">Участник</div>
            <div id="players" class="position-sticky"></div>
            <small id="choice"><span class="red"> не выбран </span></small>
            <?php if($currentPlayer == null): ?>
<input type="hidden" id="player" name="player"  value="0">
            <input type="hidden" id="_playerName"  value="">
<?php else: ?>
<input type="hidden" id="player" name="player"  value="<?php echo e($currentPlayer->id); ?>">
            <input type="hidden" id="_playerName"  value="<?php echo e($currentPlayer->fio); ?>">
<?php endif; ?>
            <input type="hidden" id="photo_id" name="photo_id"  value="0" >
            <input type="hidden" id="bid_id" name="bid_id" value="<?php echo e($bid->id); ?>">
            <input type="hidden" id="team_id" name="team_id" value="<?php echo e($team->id); ?>">
            <?php if($currentPlayerAttr->has('type') && $currentPlayerAttr->get('type') == 0): ?>
            <div id="number_text">Номер игрока в команде</div>
            <div id="number" name="number" style="width: 100%;"></div>
            <div id="position_text" style="padding-top: 20px;">Позиция игрока в команде</div>
            <select id="position" name="position" style="width: 100%;">
            <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($position->id); ?>" ><?php echo e($position->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <div id="captain_text" style="padding-top: 20px;">Капитан в команде</div>
            <select id="captain" name="position" style="width: 100%;">
                <?php $__currentLoopData = $captains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $captain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($captain->id); ?>" ><?php echo e($captain->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div id="dol_text" class="hidden">Должность в команде</div>
            <select id="dol" name="dol" style="width: 100%;" class="hidden">
                <?php $__currentLoopData = $dols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dol->id); ?>" ><?php echo e($dol->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php else: ?>
                <div id="number_text" class="hidden">Номер игрока в команде</div>
                <div id="number" class="hidden" name="number" style="width: 100%;"></div>
                <div id="position_text" class="hidden" style="padding-top: 20px;">Позиция игрока в команде</div>
                <select id="position" name="position" class="hidden" style="width: 100%;">
                    <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($position->id); ?>" ><?php echo e($position->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <div id="captain_text" class="hidden" style="padding-top: 20px;">Капитан в команде</div>
                <select id="captain" name="position" class="hidden" style="width: 100%;">
                    <?php $__currentLoopData = $captains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $captain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($captain->id); ?>" ><?php echo e($captain->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div id="dol_text">Должность в команде</div>
                <select id="dol" name="dol" style="width: 100%;">
                    <?php $__currentLoopData = $dols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dol->id); ?>" ><?php echo e($dol->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>
            <div style="padding-top: 20px;">Фотография игрока</div>
            <select id="photo" name="photo" style="width: 100%;">
                <option value="0">/storage/images/no_image.png</option>
            </select>
            <div class="text-center">
                <button type="submit" id="save_button" class="btn btn-primary navbar-btn" disabled>Записать</button>
                <button type="button" id="photo_button" class="btn btn-secondary navbar-btn" disabled>Новое фото</button>
                <?php if($roles->contains(1)): ?> <button type="button" class="btn btn-secondary navbar-btn" onclick="document.location.href = '/home/players/add/frombid/151/590';">Новый игрок</button> <?php endif; ?>
            </div>
            <?php if($roles->contains(1)): ?>

            <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <?php endif; ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Заявочный лист игроков<?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Результат заявки <?php $__env->endSlot(); ?>
            <h2><u>Заявленные игроки</u></h2>
            <table class="w-100" id="table-players-on-bid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                </tr>
                <tbody>
                <?php $__currentLoopData = $bidplayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>"  class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php if($player->number > 0): ?><?php echo e($player->number); ?><?php endif; ?></td>
                        <td class="text-left p-3"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family.' '.$player->name); ?> <?php if($player->captain_id > 0): ?> (<?php echo e($player->captain->shortname); ?>) <?php endif; ?></a></td>
                        <td class="text-center"><?php echo e($player->position->shortname); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($bidplayers) > 0): ?>
                <p>Итого за заявочное окно - <strong class="red" id="bidplayercount"><?php echo e(count($bidplayers)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>
            <div class="x_title"></div>
            <h2><u>Отзаявленные игроки</u></h2>
            <table class="w-100" id="table-players-on-unbid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Игрок</th>
                    <th align="center">Позиция</th>
                    <?php if($tournament->status_id <= 1): ?><th align="center"></th><?php endif; ?>
                </tr>
                <tbody>
                <?php $__currentLoopData = $unbidplayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>"  class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php if($player->number > 0): ?><?php echo e($player->number); ?><?php endif; ?></td>
                        <td class="text-left p-3"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family.' '.$player->name); ?> <?php if($player->captain_id > 0): ?> (<?php echo e($player->captain->shortname); ?>) <?php endif; ?></a></td>
                        <td class="text-center"><?php echo e($player->position->shortname); ?></td>
                        <?php if($tournament->status_id <= 1): ?><td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td><?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($unbidplayers) > 0): ?>
                <p>Итого за заявочное окно - <strong class="red" id="unbidplayercount"><?php echo e(count($unbidplayers)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Заявочный лист административных лиц<?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?>Результат заявки <?php $__env->endSlot(); ?>
            <h2><u>Заявленные представители</u></h2>
            <table class="w-100" id="table-coaches-on-bid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Фамилия Имя Отчество</th>
                    <th align="center">Должность</th>
                </tr>
                <tbody>
                <?php $__currentLoopData = $bidadmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php echo e($loop->index + 1); ?></td>
                        <td class="text-left p-3"><a href="/"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family.' '.$player->name); ?> <?php if($player->captain_id > 0): ?> (<?php echo e($player->captain->shortname); ?>) <?php endif; ?></a></a></td>
                        <td class="text-center"><?php echo e($player->post->name); ?></td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($bidadmins) > 0): ?>
                <p>Итого за заявку - <strong class="red" id="bidcoachcount"><?php echo e(count($bidadmins)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>

            <h2><u>Отзаявленные представители</u></h2>
            <table class="w-100" id="table-coaches-on-unbid">
                <tr>
                    <th align="center">#</th>
                    <th align="center">Фамилия Имя Отчество</th>
                    <th align="center">Должность</th>
                    <?php if($tournament->status_id <= 1): ?><th align="center"></th><?php endif; ?>
                </tr>
                <tbody>
                <?php $__currentLoopData = $unbidadmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-bidplayer="<?php echo e($player->id); ?>" class="border-top <?php if($loop->index % 2 == 0): ?>bg-light <?php endif; ?>">
                        <td class="text-center"><?php echo e($loop->index + 1); ?></td>
                        <td class="text-left p-3"><a href="/"><a href="<?php echo e(route('person', $player->person->url)); ?>"><?php echo e($player->family.' '.$player->name); ?> <?php if($player->captain_id > 0): ?> (<?php echo e($player->captain->shortname); ?>) <?php endif; ?></a></a></td>
                        <td class="text-center"><?php echo e($player->post->name); ?></td>
                        <?php if($tournament->status_id <= 1): ?><td class="text-center remove"><i class="fa fa-close" title="Вернуть в команду"></i></td><?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($unbidadmins) > 0): ?>
                <p>Итого за заявку - <strong class="red" id="unbidcoachcount"><?php echo e(count($unbidadmins)); ?></strong></p>
            <?php else: ?>
                <p class="text-center">нет</p>
            <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
</div>
<input id="tourn_status" type="hidden" value="<?php echo e($tournament->status_id); ?>">
<?php if($currentPlayerAttr->has('type')): ?> <input id="_typebid" type="hidden" value="<?php echo e($currentPlayerAttr->get('type')); ?>">
<?php else: ?> <input id="_typebid" type="hidden" value="0">
<?php endif; ?>
<?php if($currentPlayerAttr->has('dol')): ?> <input id="_dol" type="hidden" value="<?php echo e($currentPlayerAttr->get('dol')); ?>">
<?php else: ?> <input id="_dol" type="hidden" value="0">
<?php endif; ?>
<?php if($currentPlayerAttr->has('number')): ?> <input id="_number" type="hidden" value="<?php echo e($currentPlayerAttr->get('number')); ?>">
<?php else: ?> <input id="_number" type="hidden" value="0">
<?php endif; ?>
<?php if($currentPlayerAttr->has('position')): ?> <input id="_position" type="hidden" value="<?php echo e($currentPlayerAttr->get('position')); ?>">
<?php else: ?> <input id="_position" type="hidden" value="0">
<?php endif; ?>
<?php if($currentPlayerAttr->has('captain')): ?> <input id="_captain" type="hidden" value="<?php echo e($currentPlayerAttr->get('captain')); ?>">
<?php else: ?> <input id="_captain" type="hidden" value="0">
<?php endif; ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>