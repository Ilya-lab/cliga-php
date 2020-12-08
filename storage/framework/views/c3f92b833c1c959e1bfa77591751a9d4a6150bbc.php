<?php $__env->startSection('title'); ?><?php echo e($news->title); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('desc'); ?>Новость Корпоративной лиги: <?php echo e($news->title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
				<section class="noqbot-main-section noqbot-stratum">
				<div class="container">
					<div class="noqbot-section-name">
						<h2>Новости</h2>
					</div>
					<div class="col-sm-11 col-xs-11 pull-right">
						<div class="row">
						<div id="noqbot-twocolumns" class="noqbot-twocolumns noqbot-haslayout">
							<div class="col-md-9 col-sm-8 col-xs-12 pull-left">
								<div class="noqbot-postdetail">
									<div class="noqbot-mathtextbox">
										<div class="noqbot-section-heading">
											<h2><?php echo e($news->title); ?></h2>
										</div>
										<p><?php echo $news->news; ?></p>
									</div>
									<div class="noqbot-tags-social noqbot-haslayout">
									<div class="noqbot-widget noqbot-tags-widget">
										<h3>Список тэгов</h3>
										<ul>
											<li><a class="noqbot-btn" href="#">футбол</a></li>
											<li><a class="noqbot-btn" href="#">хоккей</a></li>
											<li><a class="noqbot-btn" href="#">баскетбол</a></li>
											<li><a class="noqbot-btn" href="#">волейбол</a></li>
											<li><a class="noqbot-btn" href="#">турнир</a></li>
											<li><a class="noqbot-btn" href="#">результаты</a></li>
											<li><a class="noqbot-btn" href="#">новости</a></li>
										</ul>
									</div>
										<div class="noqbot-social-share pull-right">
											<i class="fa fa-share-square-o"></i>
											<span>Использовать социальные сети:</span>
											<ul>
												<li class="facebook"><a href="<?php echo e(route('redirect',['youtube'])); ?>"><i data-iconname="Перейти в YouTube" class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a></li>
												<li class="twitter"><a href="<?php echo e(route('redirect',['vk'])); ?>"><i data-iconname="Перейти вКонтакт" class="fa fa-vk fa-2x" aria-hidden="true"></i></a></li>
												<li class="instagram"><a href="<?php echo e(route('redirect',['instagram'])); ?>"><i data-iconname="Перейти в Instgram" class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
												<li class="whatsapp"><a href="<?php echo e(route('redirect',['whatsapp'])); ?>"><i data-iconname="Перейти в WhatsApp" class="fa fa-whatsapp fa-2x" aria-hidden="true"></i></a></li>
												<li class="google"><a href="javascript().html" data-toggle="modal" data-target="#noqbot-feedback"><i data-iconname="Отправить письмо" class="fa fa-envelope fa-2x" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div>
									<div id="noqbot-comments" class="noqbot-comments">
										<div class="noqbot-section-heading">
											<h2>Последние новости</h2>
										</div>
										<ul>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/1.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/2.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/3.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/4.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/5.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
											<li>
												<div class="noqbot-comment">
													<figure>
														<a href="#">
															<img src="/images/gallery/6.png" alt="image description">
														</a>
													</figure>
													<div class="noqbot-commentdata">
														<span class="noqbot-theme-tag"><time datetime="2016-05-03">2 июля 2020</time></span>
														<a class="noqbot-btnreply" href="#">Поделиться</a>
														<div class="noqbot-section-heading">
															<h3>ОНЛАЙН ТУРНИР ПО ШАХМАТАМ И ЧТО?ГДЕ?КОГДА?</h3>
														</div>
														<div class="noqbot-description">
															<p>Сегодня 29 июля в 20:00 в онлайн режиме пройдут сразу 2 турнира в рамках Спартакиады Корпоративной Лиги!
															Проект проходит при поддержке – Россвязи, МРО СоюзМаш России и Космической связи.
															Онлайн турнир по спортивному Что? Где? Когда? (Площадка для участников - zoom)
															Онлайн турнир по быстрым шахматам
															Площадка для участников - mskchess.ru
															Почувствуй соревнования не выходя из дома!</p>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div id="noqbot-leavecomment" class="noqbot-leavecomment">
										<div class="noqbot-section-heading">
											<h2>Оставьте свой комментарий</h2>
										</div>
										<form id="noqbot-commentform" class="noqbot-commentform" method="post" action="#" enctype="text/plain">
											<fieldset>
												<div class="form-group">
													<input type="text" name="name" class="form-control" placeholder="Имя" required>
												</div>
												<div class="form-group">
													<input type="email" name="email" class="form-control" placeholder="Почта" required>
												</div>
												<div class="form-group">
													<textarea name="message" placeholder="Текст сообщения" required></textarea>
												</div>
												<div class="form-group">
													<button class="noqbot-btn" type="submit">Отправить</button>
												</div>
											</fieldset>
										</form>
										
										
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-4 col-xs-12">
								<aside id="noqbot-sidebar" class="noqbot-sidebar">
									<div class="noqbot-widget noqbot-search">
										<form class="form-search">
											<fieldset>
												<input type="search" placeholder="Поиск игрока..." class="form-control">
												<button type="submit"><i class="fa fa-search"></i></button>
											</fieldset>
										</form>
									</div>
									<div class="noqbot-widget noqbot-catagories-widget">
										<h3>Категории новостей</h3>
										<ul>
											<li><a href="#"><em>Футбол</em><i>389</i></a></li>
											<li><a href="#"><em>Баскетбол</em><i>203</i></a></li>
											<li><a href="#"><em>Волейбол</em><i>256</i></a></li>
											<li><a href="#"><em>Хоккей</em><i>52</i></a></li>
											<li><a href="#"><em>Настольный теннис</em><i>43</i></a></li>
											<li><a href="#"><em>Дартс</em><i>23</i></a></li>
											<li><a href="#"><em>Керлинг</em><i>389</i></a></li>
										</ul>
									</div>
									<div class="noqbot-widget noqbot-tags-widget">
										<h3>Список тэгов</h3>
										<ul>
											<li><a class="noqbot-btn" href="#">футбол</a></li>
											<li><a class="noqbot-btn" href="#">хоккей</a></li>
											<li><a class="noqbot-btn" href="#">баскетбол</a></li>
											<li><a class="noqbot-btn" href="#">волейбол</a></li>
											<li><a class="noqbot-btn" href="#">турнир</a></li>
											<li><a class="noqbot-btn" href="#">результаты</a></li>
											<li><a class="noqbot-btn" href="#">новости</a></li>
										</ul>
									</div>
								</aside>
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