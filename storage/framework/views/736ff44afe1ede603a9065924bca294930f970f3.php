<?php $__env->startSection('title'); ?>Протокол футбольного матча <?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?><script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcore.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxbuttons.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnotification.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxloader.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/globalization/globalize.culture.ru-RU.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxnumberinput.js').'?v='.config('app.version')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jqwidgets/jqxcheckbox.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.base.css').'?v='.config('app.version')); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo e(asset('js/jqwidgets/styles/jqx.bootstrap.css').'?v='.config('app.version')); ?>" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_footer'); ?>
    <script type="text/javascript" src="<?php echo e(asset('resources/home/protocol.js').'?v='.config('app.version')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<button type="button" class="btn btn-default" id="back" onclick="history.back();">Назад</button>
<div id="grid"></div>
<div id="loader"></div>
<div class="ln_solid"></div>
<div id="messageNotification">
    <div id="message"></div>
</div>

<div class="row m-3">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Протокол матча <?php if($match->home): ?><?php echo e($match->home->name); ?> <?php else: ?><small class="red">нет</small><?php endif; ?> - <?php if($match->away): ?><?php echo e($match->away->name); ?> <?php else: ?><small class="red">нет</small><?php endif; ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: none">
                <div class="row m-3"><small>Дата и время игры - </small><strong><?php if($match->datetime): ?><?php echo e(date('d.m.y   H:i', strtotime($match->datetime))); ?><?php endif; ?></strong></div>
                <div class="row m-3"><small>Стадион, арена, площадка - </small><strong><?php echo e($match->place->field->arena->name); ?> <?php if($match->place->field->number > 0): ?> (<?php echo e($match->place->field->number); ?>) <?php endif; ?></strong></div>
                <div class="row m-3"><small>Стадия - </small><strong><?php echo e($match->mainstage->name); ?></strong></div>
                <div class="row m-3"><small>Этап - </small><strong><?php echo e($match->tour->name); ?></strong></div>
                <div class="row m-3"><small>Статус - </small><span class="status-circle <?php if($match->status_id == 1): ?>bg-green <?php elseif($match->status_id == 0): ?>bg-red <?php else: ?> bg-blue <?php endif; ?> mr-2"></span><strong><?php echo e($match->status->name); ?></strong></div>
                <div class="row m-3"><small>Судьи - </small><strong>нет</strong></div>
            </div>
        </div>
    </div>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Действия <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Ввод и корректировка протокола <?php $__env->endSlot(); ?>
        <div class="form-group row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="home_button" class="btn btn-primary w-100">Состав «<?php if($match->home): ?><?php echo e($match->home->name); ?><?php else: ?>нет<?php endif; ?>»</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести состав команды хозяев
            </div>
        </div>
        <div class="form-group row border-bottom pb-3">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="away_button" class="btn btn-primary w-100">Состав «<?php if($match->away): ?><?php echo e($match->away->name); ?><?php else: ?>нет<?php endif; ?>»</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести состав команды гостей
            </div>
        </div>
        <div class="form-group row border-bottom pb-3">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="forma_button" class="btn btn-info w-100">Форма команд</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Ввести цвет формы команд
            </div>
        </div>

        <div id="rowStart" class="form-group row <?php if($match->status_id != 0): ?> hidden <?php endif; ?>">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="start_button" class="btn btn-success w-100">Начать матч</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Изменить статус матча на «идёт»
            </div>
        </div>

        <div id="rowFinish" class="form-group row border-bottom pb-3  <?php if($match->status_id >= 2): ?> hidden <?php endif; ?>">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="finish_button" class="btn btn-primary w-100">Завершить матч</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Изменить статус матча на «окончен» и зафиксировать результат
            </div>
        </div>

        <div id="rowCancel" class="form-group row border-bottom pb-3 <?php if($match->status_id != 2): ?> hidden <?php endif; ?>">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" id="cancel_button" class="btn btn-danger w-100">Отменить результат</button>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 small">
                Отменить результат матча и перевести в статус «не начался»
            </div>
        </div>
        <form class="form-horizontal form-label-left">
            <div class="form-group row">
                <table class="w-100">
                    <tr>
                        <th width="45%" class="text-right"><?php if( $match->home): ?><?php echo e($match->home->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                        <th width="10%"></th>
                        <th width="45%" class="text-left"><?php if( $match->away): ?><?php echo e($match->away->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                    </tr>
                    <tr>
                        <td align="right"><div id="homeScore"></div></td>
                        <td></td>
                        <td align="left"><div id="awayScore"></div></td>
                    </tr>
                </table>
            </div>
            <div class="w-100 border-bottom m-2"></div>
            <?php if($match->mainstage->levels_id == 5 || $match->mainstage->levels_id == 6): ?>
                <div class="form-group row">
                    <input id="addtime" type="checkbox" />Дополнительное время и пенальти
                    <div id="addTimePanel" style="display: none;" class="w-100  border-bottom m-2 pb-2">
                        <table class="w-100">
                            <tr>
                                <th width="45%" class="text-right"><?php if( $match->home): ?><?php echo e($match->home->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                                <th width="10%"></th>
                                <th width="45%" class="text-left"><?php if( $match->away): ?><?php echo e($match->away->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                            </tr>
                            <tr>
                                <td align="right"><div id="homeAddScore"></div></td>
                                <td></td>
                                <td align="left"><div id="awayAddScore"></div></td>
                            </tr>
                        </table>
                        <input id="penaltytime" type="checkbox" />Пенальти
                        <div id="panaltyPanel" style="display: none;" class="w-100  border-bottom m-2 pb-2">
                            <table class="w-100">
                                <tr>
                                    <th width="45%" class="text-right"><?php if( $match->home): ?><?php echo e($match->home->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                                    <th width="10%"></th>
                                    <th width="45%" class="text-left"><?php if( $match->away): ?><?php echo e($match->away->name); ?><?php else: ?> хозяев <?php endif; ?></th>
                                </tr>
                                <tr>
                                    <td align="right"><div id="homePenaltyScore"></div></td>
                                    <td></td>
                                    <td align="left"><div id="awayPenaltyScore"></div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Состав «<?php if($match->home): ?><?php echo e($match->home->name); ?><?php else: ?>нет<?php endif; ?>» <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Состав команды на игру <?php $__env->endSlot(); ?>
        1234
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Состав «<?php if($match->away): ?><?php echo e($match->away->name); ?><?php else: ?>нет<?php endif; ?>» <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Состав команды на игру <?php $__env->endSlot(); ?>
        1234
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Статистика <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Статистика матча <?php $__env->endSlot(); ?>
            <div class="form-group row">
                <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Количество зрителей</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="viewerMatch"></div>
                </div>
            </div>
    <?php echo $__env->renderComponent(); ?>
    <?php $__env->startComponent('components.box_block'); ?>
        <?php $__env->slot('title'); ?>Лучшие игроки <?php $__env->endSlot(); ?>
        <?php $__env->slot('description'); ?> Лучшие игроки матча <?php $__env->endSlot(); ?>
        1234
    <?php echo $__env->renderComponent(); ?>
</div>
<input id="_status" type="hidden" value="<?php echo e($match->status_id); ?>">
<input id="_homeScore" type="hidden" value="<?php echo e($match->homescore == null ? 0 : $match->homescore); ?>">
<input id="_awayScore" type="hidden" value="<?php echo e($match->awayscore == null ? 0 : $match->awayscore); ?>">
<style>
#homeScore input, #awayScore input {
    font-size: 40px;
}
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>