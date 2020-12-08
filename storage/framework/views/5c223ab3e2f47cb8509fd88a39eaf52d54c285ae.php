<?php $__env->startSection('title'); ?>Игрок команды «<?php echo e($player->team); ?>» <?php echo e($player->family.' '.$player->name.' '.$player->surname); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('desc'); ?>Игрок Корпоративной лиги <?php echo e($player->family.' '.$player->name.' '.$player->surname); ?>, выступающий за команду «<?php echo e($player->team); ?>»<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e(var_dump($player)); ?>

	<section class="noqbot-main-section noqbot-stratum">
				<div class="container">
					<div class="noqbot-section-name">
						<h2>Статистика игрока</h2>
					</div>
				<div class="col-sm-11 col-xs-11 pull-right">
					<div id="noqbot-twocolumns" class="noqbot-twocolumns noqbot-main-section noqbot-stratum">
						<div class="col-sm-8 col-xs-12 pull-left">
							<div class="noqbot-player-detail noqbot-stratum">
								<div class="noqbot-player-data noqbot-stratum">
									<div class="noqbot-player-info noqbot-stratum">
										<div class="row">
											<div class="col-sm-4 col-xs-12">
												<section>
													<div class="container">
														<div class="row">
															<div class="col-md-12">
																<div class="card profile-card-3">
																	<div class="background-block">
																	</div>
																	<div class="profile-thumb-block">
																		<img src="images/player/7196.jpg" alt="profile-image" class="profile"/>
																	</div>
																	<div class="card-content">
																	<h2><img src="images/team-logo/th.jpg" alt="profile-image" class="profile"/><small>ГАРАНТ Энерго</small></h3>
																	<div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</section>
											</div>
											<div class="col-sm-8 col-xs-12">
												<div class="noqbot-playcontent">
													<a href="#" class="noqbot-theme-tag">Нападающий</a>
													<h3><a href="#">Сысоев Андрей Викторович</a></h3>
													<span class="noqbot-stars"><span></span></span>
												</div>
												<ul>
													<li>Команда:</li>
													<li>ГАРАНТ Энерго</li>
													<li>Номер:</li>
													<li>9</li>
													<li>Дата рождения:</li>
													<li>18 марта 1991 года</li>
													<li>Полных лет:</li>
													<li>28</li>
													<li>Гражданство:</li>
													<li>Россия</li>
													<li>Позиция:</li>
													<li>Правый нападающий</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="noqbot-themetabs">
									<h3>Результаты команды</h3>
										<ul class="noqbot-themetabnav" role="tablist">
											<li role="presentation" class="active">
												<a href="#recentvictories" aria-controls="recentvictories" role="tab" data-toggle="tab">Январь</a>
											</li>
											<li role="presentation">
												<a href="#recentdefeat" aria-controls="recentdefeat" role="tab" data-toggle="tab">Февраль</a>
											</li>
											<li role="presentation">
												<a href="#earlierstats" aria-controls="earlierstats" role="tab" data-toggle="tab">Март</a>
											</li>
										</ul>
										<div class="tab-content noqbot-themetabcontent">
											<div role="tabpanel" class="tab-pane active" id="recentvictories">
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">25<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Кубок Банка России</span>
														<h4>СПЕЦСВЯЗЬ <span>2 - 5</span> ГАРАНТ Энерго</h4>
														<address>Площадка №2</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">27<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ГАРАНТ Энерго <span>2 - 6</span> МОКБ МАРС ГК РОСАТОМ</h4>
														<address>Площадка №1</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">28<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ФЕНИКС КОНТАКТ РУС <span>4 - 7</span> ГАРАНТ Энерго</h4>
														<address>Площадка №3</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">29<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Кубок Банка России</span>
														<h4>ГАРАНТ Энерго <span>4 - 5</span> РОСОБОРОНЭКСПОРТ</h4>
														<address>Площадка №2</address>
													</div>
												</div>
												
											</div>
											<div role="tabpanel" class="tab-pane" id="recentdefeat">
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">27<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ГАРАНТ Энерго <span>4 - 5</span> МОКБ МАРС ГК РОСАТОМ</h4>
														<address>Площадка №1</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">28<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ФЕНИКС КОНТАКТ РУС <span>4 - 15</span> ГАРАНТ Энерго</h4>
														<address>Площадка №3</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">01<span>марта</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Кубок Банка России</span>
														<h4>ГАРАНТ Энерго <span>14 - 15</span> ФЕНИКС КОНТАКТ РУС</h4>
														<address>Площадка №2</address>
													</div>
												</div>
											</div>
											<div role="tabpanel" class="tab-pane" id="earlierstats">
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">27<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ГАРАНТ Энерго <span>4 - 5</span> МОКБ МАРС ГК РОСАТОМ</h4>
														<address>Площадка №1</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">28<span>января</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Чемпионат</span>
														<h4>ФЕНИКС КОНТАКТ РУС <span>4 - 15</span> ГАРАНТ Энерго</h4>
														<address>Площадка №3</address>
													</div>
												</div>
												<div class="noqbot-oldmatchresult">
													<time class="noqbot-matchdate" datetime="2016-05-13">01<span>марта</span></time>
													<div class="noqbot-matchdetail">
														<span class="noqbot-theme-tag">Кубок Банка России</span>
														<h4>ГАРАНТ Энерго <span>14 - 15</span> ФЕНИКС КОНТАКТ РУС</h4>
														<address>Площадка №2</address>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsfooter'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.general', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>