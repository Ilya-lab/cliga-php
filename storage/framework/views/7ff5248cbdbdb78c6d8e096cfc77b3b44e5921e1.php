<div id="noqbot-playerscrollbar" class="noqbot-players noqbot-playerscrollbar">
    <div class="noqbot-pointtable-title-full">
        <div class="noqbot-box"><?php echo e($tournament->name); ?></div>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $players['forwards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="noqbot-player">
        <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
            <div class="noqbot-playcontent">
			<div class="noqbot-posttitle-bestplayers"><h3><a href="<?php echo e(route('tournament_forwards', [$tournament->url])); ?>">Лучший бомбардир</a></h3></div>
			<div><h3 style="margin: 4px 0;"><a href="<?php echo e(route('tournament_player', [$tournament->url, $pl->bid->person->url])); ?>"><?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?></a></h3></div>
			<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="<?php echo e(route('tournament_team',[$tournament->url, $pl->bid->team->url])); ?>"><b><?php echo e($pl->bid->team->name); ?></b></a></h4></div>
			<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
			<div class="noqbot-statistic noqbot-goals">
			<span class="noqbot-icon icon-Icon1"></span>
			<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->games); ?></span></h2>
			</div>
			<div class="noqbot-statistic noqbot-activeplayers">
			<span class="noqbot-icon icon-Icon2"></span>
			<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->football->mvpdefenders); ?></span></h2>
			</div>
			</div>
            </div>
        </div>
        <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
            <div class="card profile-card-5">
                <div class="background-block"></div>
                <div class="profile-thumb-block">
                    <?php if($pl->bid->photo): ?>
                        <?php $__currentLoopData = $pl->bid->photo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($photo->thumb_id == 9): ?>
                                <img src="<?php echo e($photo->filename); ?>" alt="<?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?> - команда <?php echo e($pl->bid->team->name); ?>" class="profile"/>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php break; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    <?php endif; ?>
    <?php $__empty_1 = true; $__currentLoopData = $players['assistants']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="<?php echo e(route('tournament_assistants', [$tournament->url])); ?>">Лучший ассистент</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="<?php echo e(route('tournament_player', [$tournament->url, $pl->bid->person->url])); ?>"><?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?></a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="<?php echo e(route('tournament_team',[$tournament->url, $pl->bid->team->url])); ?>"><b><?php echo e($pl->bid->team->name); ?></b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->games); ?></span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->football->mvpdefenders); ?></span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        <?php if($pl->bid->photo): ?>
                            <?php $__currentLoopData = $pl->bid->photo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($photo->thumb_id == 9): ?>
                                    <img src="<?php echo e($photo->filename); ?>" alt="<?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?> - команда <?php echo e($pl->bid->team->name); ?>" class="profile"/>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php break; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    <?php endif; ?>
    <?php $__empty_1 = true; $__currentLoopData = $players['defenders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="<?php echo e(route('tournament_defenders', [$tournament->url])); ?>">Лучший по системе "гол+пас"</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="<?php echo e(route('tournament_player', [$tournament->url, $pl->bid->person->url])); ?>"><?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?></a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="<?php echo e(route('tournament_team',[$tournament->url, $pl->bid->team->url])); ?>"><b><?php echo e($pl->bid->team->name); ?></b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->games); ?></span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->football->mvpdefenders); ?></span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        <?php if($pl->bid->photo): ?>
                            <?php $__currentLoopData = $pl->bid->photo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($photo->thumb_id == 9): ?>
                                    <img src="<?php echo e($photo->filename); ?>" alt="<?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?> - команда <?php echo e($pl->bid->team->name); ?>" class="profile"/>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php break; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    <?php endif; ?>
	<?php $__empty_1 = true; $__currentLoopData = $players['defenders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="<?php echo e(route('tournament_defenders', [$tournament->url])); ?>">Лучший защитник</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="<?php echo e(route('tournament_player', [$tournament->url, $pl->bid->person->url])); ?>"><?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?></a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="<?php echo e(route('tournament_team',[$tournament->url, $pl->bid->team->url])); ?>"><b><?php echo e($pl->bid->team->name); ?></b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->games); ?></span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->football->mvpdefenders); ?></span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        <?php if($pl->bid->photo): ?>
                            <?php $__currentLoopData = $pl->bid->photo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($photo->thumb_id == 9): ?>
                                    <img src="<?php echo e($photo->filename); ?>" alt="<?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?> - команда <?php echo e($pl->bid->team->name); ?>" class="profile"/>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php break; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    <?php endif; ?>
	<?php $__empty_1 = true; $__currentLoopData = $players['defenders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="noqbot-player">
            <div id="noqbot-block-container" class="col-sm-9 col-xs-12 pull-right">
                <div class="noqbot-playcontent">
				<div class="noqbot-posttitle-bestplayers"><h3><a href="<?php echo e(route('tournament_defenders', [$tournament->url])); ?>">Лучший вратарь</a></h3></div>
				<div><h3 style="margin: 4px 0;"><a href="<?php echo e(route('tournament_player', [$tournament->url, $pl->bid->person->url])); ?>"><?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?></a></h3></div>
				<div id="noqbot-block-container" class="col-sm-8 col-xs-12"><h4 class="noqbot-team-name"><a href="<?php echo e(route('tournament_team',[$tournament->url, $pl->bid->team->url])); ?>"><b><?php echo e($pl->bid->team->name); ?></b></a></h4></div>
				<div id="noqbot-block-container" class="col-sm-4 col-xs-12 pull-right">
				<div class="noqbot-statistic noqbot-goals">
				<span class="noqbot-icon icon-Icon1"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="15" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->games); ?></span></h2>
				</div>
				<div class="noqbot-statistic noqbot-activeplayers">
				<span class="noqbot-icon icon-Icon2"></span>
				<h2><span class="noqbot-statistic-count" data-from="0" data-to="11" data-speed="8000" data-refresh-interval="50"><?php echo e($pl->football->mvpdefenders); ?></span></h2>
				</div>
				</div>
                </div>
            </div>
            <div id="noqbot-block-container" class="col-sm-3 col-xs-12" style="padding-left: 0; padding-right: 15px;">
                <div class="card profile-card-5">
                    <div class="background-block"></div>
                    <div class="profile-thumb-block">
                        <?php if($pl->bid->photo): ?>
                            <?php $__currentLoopData = $pl->bid->photo->thumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($photo->thumb_id == 9): ?>
                                    <img src="<?php echo e($photo->filename); ?>" alt="<?php echo e($pl->bid->family); ?> <?php echo e($pl->bid->name); ?> <?php echo e($pl->bid->surname); ?> - команда <?php echo e($pl->bid->team->name); ?>" class="profile"/>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php break; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div><h3 style="margin: 4px 0;">Нет игроков</h3></div>
    <?php endif; ?>
</div>
<!-- <div class="noqbot-btnbox">
    <a class="noqbot-btn" href="#"><span>Подробнее...</span></a>
    <div class="noqbot-themebtnnext"><span class="fa fa-angle-down"></span></div>
    <div class="noqbot-themebtnprev"><span class="fa fa-angle-up"></span></div>
</div> -->
