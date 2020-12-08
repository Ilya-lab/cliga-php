<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Лига')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-bootstrap.min.css').'?v='.config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-cancel.min.css').'?v='.config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-jquery.css').'?v='.config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-base.css').'?v='.config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-responsive.css').'?v='.config('app.version')); ?>">
    <script src="<?php echo e(asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')); ?>"></script>
    <link rel="shortcut icon" href="<?php echo e(asset('/images/favicon.ico')); ?>" type="image/vnd.microsoft.icon" />
    <meta property="og:url" content="<?php echo e(url('/')); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta property="og:image" content="<?php echo e(url('/')); ?>" />
    <meta itemprop="og:headline" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta itemprop="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <!-- <script>
        var slideIndex = 1;
        showSlides(slideIndex);
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
        document.getElementById('re').style.width = "100%";
        document.getElementById('re').style.height = "50%";

    </script> -->
</head>

<body>
<div id="noqbot-frontface" class="noqbot-frontface noqbot-stratum">
    <div id="noqbot-browsing-responsive" class="noqbot-browsing-responsive noqbot-navigation collapse navbar-collapse">
        <span id="noqbot-close" class="noqbot-close fa fa-close"></span>
        <div class="noqbot-colhalf">
            <ul>
                <li class="active menu-item-has-children">
                    <a href="#">Лига</a>
                </li>
                <li class="menu-item-has-children">
                    <a href="#">Партнеры</a>
                </li>
                <li>
                    <a href="buyticket.html">Футбол</a>
                </li>
            </ul>
        </div>
        <div class="noqbot-colhalf">
            <ul>
            </ul>
        </div>
    </div>
    <header id="noqbot-header" class="noqbot-header noqbot-stratum">
        <div id="noqbot-sticky-block" class="container">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-9 col-xs-12">
                        <div class="noqbot-topbar noqbot-stratum">
                            <nav id="noqbot-topaddnav" class="noqbot-topaddnav">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#noqbot-addnavigationm-mobile">
                                        <i class="fa fa fa-bars"></i>
                                    </button>
                                </div>
                                <div id="noqbot-addnavigationm-mobile" class="noqbot-addnavigationm-mobile collapse navbar-collapse">
                                    <div class="noqbot-colhalf pull-right">
                                        <nav class="noqbot-addnav">
                                            <ul>
                                                <?php $__currentLoopData = InterfaceModule::menu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="noqbot-mobile-li">
                                                    <a href="#"><?php echo e($menu->name); ?></a>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <nav id="noqbot-nav" class="noqbot-nav brand-center">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#noqbot-browsing-responsive" style="display:none;">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <strong class="noqbot-logo">
                                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('images/logo.png')); ?>" alt="image description"></a>
                                </strong>
                            </div>
                            <div id="noqbot-navigation" class="noqbot-navigation">
                                <div class="noqbot-colhalf">
                                    <ul>
                                        <?php $__currentLoopData = InterfaceModule::menu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php if($loop->first): ?> active <?php endif; ?>">
                                            <a href="#"><?php echo e($menu->name); ?></a>
                                            <ul class="noqbot-dropdown-menu">
                                            <?php $__currentLoopData = $menu->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><a href="<?php echo e($mm->url); ?>"><?php echo e($mm->name); ?></a></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="#"><i class=" fa fa-navicon"></i></a>
                                            <ul>
                                                <li><a href="javascript().html" data-toggle="modal" data-target="#noqbot-login">Вход</a></li>
												<li>
                                                    <div class="noqbot-cart">
                                                        <a href="javascript:void(0)" class="dropdown-toggle" id="noqbot-cartdropdown" data-toggle="dropdown">
                                                            Услуги
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="noqbot-cart">
                                                        <a href="javascript:void(0)" class="dropdown-toggle" id="noqbot-cartdropdown" data-toggle="dropdown">
                                                            Магазин
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a id="noqbot-btn-search" href="javascript:void(0)">Поиск</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <!-- <h2 class="noqbot-telephone-number"><a href="tel:+74952268527">+7 495 226-85-27</a></h2> -->
                        <div class="wrapper-icons-top">
                            <ul>
                                <li class="telephone"><a href="tel:+74952268527"><i class="fa fa-phone fa-2x" aria-hidden="true"></i></a></li>
                                <li class="facebook"><a href="<?php echo e(route('redirect',['youtube'])); ?>"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a></li>
								<li class="vkontakte"><a href="https://vk.com/corliga"><i class="fa fa-vk fa-2x" aria-hidden="true"></i></a></li>
                                <li class="instagram"><a href="<?php echo e(route('redirect',['instagram'])); ?>"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
                                <li class="whatsapp"><a href="<?php echo e(route('redirect',['whatsapp'])); ?>"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i></a></li>
                                <li class="google"><a href="javascript().html" data-toggle="modal" data-target="#noqbot-feedback"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="noqbot-default-block" class="container" style="background:none;">
            <div class="row">
                <div class="col-sm-12">
                    <div id="myCarousel" class="row carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                                $currentM = 0;
                                $games = Matches::lentaAllSport();
                            ?>
                            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($loop->index % 6 == 0): ?>
                                    <div class="item <?php if($currentM == 0): ?> <?php for($i=$loop->index; $i<count($games); $i++): ?> <?php if($i==$loop->index+6): ?> <?php break; ?>; <?php endif; ?> <?php if($games[$i]->status_id < 2 && $currentM == 0): ?>active<?php $currentM = $i;?> <?php break; ?> <?php endif; ?> <?php endfor; ?> <?php endif; ?>">
                                        <ul class="thumbnails">
                                            <?php endif; ?>
                                            <li id="noqbot-name-team-result-block" class="col-sm-2">
                                                <div class="caption-box">
                                                    <p class="noqbot-info-result"><i id="noqbot-news-clock-icon" class="fa fa-info-circle"></i><?php echo e($match->mainstage->tournament->sport->name); ?>. <?php echo e($match->mainstage->tournament->name); ?>. <?php if($match->status_id == 1): ?><a href="<?php echo e(route('tournament_match',[$match->mainstage->tournament->url, $match->id ])); ?>"><img height="20" src="<?php echo e(asset('/images/live.png')); ?>" width="40"></a><?php endif; ?></p>
                                                    <p class="noqbot-time-result"><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i><?php echo e($match->tour->shortname.' - '.date('d.m.y H:i', strtotime($match->datetime))); ?></p>
                                                    <div id="noqbot-name-team-result-home" class="col-sm-12">
                                                        <div id="noqbot-name-team" class="col-sm-10">
                                                            <h3 class="noqbot-name-team-result-home"><?php if($match->home): ?><?php echo e($match->home->name); ?><?php else: ?> <?php echo e($match->homename); ?> <?php endif; ?></h3>
                                                        </div>
                                                        <div id="noqbot-name-result" class="col-sm-2">
                                                            <h3 class="noqbot-score-team-result-home"><?php if($match->status_id > 0): ?><?php echo e($match->homescore); ?><?php endif; ?></h3>
                                                        </div>
                                                    </div>
                                                    <div id="noqbot-name-team-result-away" class="col-sm-12">
                                                        <div id="noqbot-name-team" class="col-sm-10">
                                                            <h3 class="noqbot-name-team-result-away"><?php if($match->away): ?><?php echo e($match->away->name); ?><?php else: ?> <?php echo e($match->awayname); ?> <?php endif; ?></h3>
                                                        </div>
                                                        <div id="noqbot-name-result" class="col-sm-2">
                                                            <h3 class="noqbot-score-team-result-away"><?php if($match->status_id > 0): ?><?php echo e($match->awayscore); ?><?php endif; ?></h3>
                                                        </div>

                                                    </div>
                                                </div>
                                            </li>
                                            <?php if($loop->index % 6 == 5 || $loop->last): ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="control-box">
                            <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
                            <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php echo $__env->yieldContent('content'); ?>
    <footer id="noqbot-footer" class="noqbot-footer noqbot-stratum">
	    <div class="noqbot-section-heading">
            <h2><span class="fa fa-table" style="padding: 0 10px;"></span>Партнеры</h2>
        </div>
        <div class="main clearfix">
            <nav id="menu" class="nav">
                <ul>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/amfr_new.png')); ?>" alt="image description">
								</span>
                            <span>Ассоциация мини-футбола России</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/fbm_new.png')); ?>" alt="image description">
								</span>
                            <span>Федерация Баскетбола Москвы</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/rs_new.png')); ?>" alt="image description">
								</span>
                            <span>Россвязь</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/smr_new.png')); ?>" alt="image description">
								</span>
                            <span>Союз Машиностроителей России</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/arb_new.png')); ?>" alt="image description">
								</span>
                            <span>Ассоциация российских банков</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/br_new.png')); ?>" alt="image description">
								</span>
                            <span>Банк России</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
								<span class="icon">
									<img src="<?php echo e(asset('images/partners/mlbl_new.png')); ?>" alt="image description">
								</span>
                            <span>Межрегиональная любительская баскетбольная лига</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="noqbot-stratum noqbot-footerinfobox">
            <div class="noqbot-bgboxone"></div>
            <div class="noqbot-bgboxtwo"></div>
            <div class="noqbot-footerinfo">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <div class="noqbot-footercol">
                                <div class="noqbot-posttitle" style="background: transparent;">
                                    <h3>Виды спорта</h3>
                                </div>
                                <div class="noqbot-stratum">
                                    <ul id="panel">
                                        <li class="animation"><a href="#">Футбол</a></li>
                                        <li class="animation"><a href="#">Баскетбол</a></li>
                                        <li class="animation"><a href="#">Волейбол</a></li>
                                        <li class="animation"><a href="#">Хоккей</a></li>
                                        <li class="animation"><a href="#">Настольный теннис</a></li>
                                        <li class="animation"><a href="#">Волейбол</a></li>
                                        <li class="animation"><a href="#">Дартс</a></li>
                                        <li class="animation"><a href="#">Керлинг</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="noqbot-footercol">
                                <div class="noqbot-posttitle" style="background: transparent;">
                                    <h3>Социальные сети</h3>
                                </div>
                                <div class="noqbot-stratum">
                                    <div class="wrapper-icons-footer">
                                        <ul>
                                            <li class="facebook"><a href="<?php echo e(route('redirect',['youtube'])); ?>"><i class="fa fa-youtube-play fa-2x" aria-hidden="true"></i></a></li>
                                            <li class="twitter"><a href="<?php echo e(route('redirect',['vk'])); ?>"><i class="fa fa-vk fa-2x" aria-hidden="true"></i></a></li>
                                            <li class="instagram"><a href="<?php echo e(route('redirect',['instagram'])); ?>"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
                                            <li class="whatsapp"><a href="<?php echo e(route('redirect',['whatsapp'])); ?>"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i></a></li>
                                            <li class="google"><a href="javascript().html" data-toggle="modal" data-target="#noqbot-feedback"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <div class="noqbot-footercol">
                                <div class="noqbot-posttitle" style="background: transparent;">
                                    <h3>Контакты</h3>
                                </div>
                                <div class="noqbot-stratum">
                                    <strong class="noqbot-logo">
                                        <a href="#">
                                            <img src="images/logo.png" alt="image description">
                                        </a>
                                    </strong>
                                </div>
                                <ul class="noqbot-contactinfo">
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <address class="noqbot-contacts-text">Адрес: г. Москва, Сущевский вал, д.56, c.5 (м. Марьина роща, м. Рижская)</address>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>
                                        <a class="noqbot-contacts-text" href="">org@cliga.ru</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <span class="noqbot-contacts-text">Оргкомитет: +7 (495) 226-85-27</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <span class="noqbot-contacts-text">Аренда: +7 (495) 226-85-27</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <address class="noqbot-contacts-text">По вопросам проведения мероприятий обращайтесь по тел.:<br>+7 (495) 226-85-27</address>
                                    </li>
                                </ul>
                                <div class="noqbot-stratum">
                                    <a class="noqbot-btn" href="#">Обратная связь</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="noqbot-footerbar">
            <div class="container">
                <span class="noqbot-copyright"><a target="_blank" href="">2005-2020 Корпоративная Лига ТМ. Все права защищены. Пользовательское соглашение</a></span>
                <nav class="noqbot-footernav">
                    <ul>
                        <li><a href="#">Лига</a></li>
                        <li><a href="#">Услуги</a></li>
                        <li><a href="#">Партнеры</a></li>
                        <li><a href="#">Футбол</a></li>
                        <li><a href="#">Баскетбол</a></li>
                        <li><a href="#">Волейбол</a></li>
                        <li><a href="#">Хоккей</a></li>
                        <li><a href="#">Настольный теннис</a></li>
                        <li><a href="#">Дартс</a></li>
                        <li><a href="#">Керлинг</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>
</div>
<div class="noqbot-searchbox">
    <a id="noqbot-close-search" class="noqbot-close-search" href="javascript:void(0)"><span class="fa fa-close"></span></a>
    <div class="noqbot-searcharea">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form class="noqbot-form-search">
                        <fieldset>
                            <input type="search" class="form-control" placeholder="Введите слово или фразу для поиска...">
                            <i class="icon-icon_search2"></i>
                        </fieldset>
                    </form>
                    <p>Для поиска нажмите "Enter"</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="noqbot-modalbox modal fade" id="noqbot-login" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="noqbot-modal-content">
            <div class="noqbot-formarea">
                <div class="noqbot-border-heading">
                    <h3>Вход в систему</h3>
                </div>
                <form class="noqbot-loginform" method="post">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="userName/email" class="form-control" placeholder="Имя пользователя">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Пароль">
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" value="rememberme" class="checkbox">
                                <em>Запомнить мне</em>
                            </label>
                            <a href="#">
                                <em>Напомнить пароль</em>
                                <i class="fa fa-question-circle"></i>
                            </a>
                        </div>
                        <div class="form-group">
                            <button class="noqbot-btn noqbot-btn-lg" type="submit">Войти на сайт</button>
                        </div>
                        <div class="noqbot-description">
                            <p>Желаете зарегистрироваться? <a href="#">Регистрация</a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!-- <div class="noqbot-logintype">
                            <div class="noqbot-border-heading">
                                <h3>Авторизация с помощью сервисов</h3>
                            </div>
                            <ul>
                                <li class="noqbot-facebook"><a href="#"></a></li>
                                <li class="noqbot-twitter"><a href="#"></a></li>
                                <li class="noqbot-googleplus"><a href="#"></a></li>
                                <li class="noqbot-linkedin"><a href="#"></a></li>
                            </ul>
                        </div> -->
        </div>
    </div>
</div>
<!-- <div class="noqbot-modalbox modal fade" id="noqbot-register" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="noqbot-modal-content">
            <div class="noqbot-formarea">
                <div class="noqbot-border-heading">
                    <h3>Регистрация на сайте</h3>
                </div>
                <form class="noqbot-loginform" method="post">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="userName" class="form-control" placeholder="Имя пользователя">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Электронная почта">
                        </div>
						<div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Пароль">
                        </div>
						<div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Подтверждение пароля">
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" value="rememberme" class="checkbox">
                                <em>Оформить подписку</em>
                            </label>
                            <a href="#">
                                <em>Подробнее о регистрации</em>
                                <i class="fa fa-question-circle"></i>
                            </a>
                        </div>
                        <div class="form-group">
                            <button class="noqbot-btn noqbot-btn-lg" type="submit">Подтвердить</button>
                        </div>
                        <div class="noqbot-description">
                            <p><a href="#"></a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
             <div class="noqbot-logintype">
                <div class="noqbot-border-heading">
                    <h3>Регистрация с помощью сервисов</h3>
                </div>
                <ul>
                    <li class="noqbot-facebook"><a href="#"></a></li>
                    <li class="noqbot-twitter"><a href="#"></a></li>
                    <li class="noqbot-googleplus"><a href="#"></a></li>
                    <li class="noqbot-linkedin"><a href="#"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div> -->
<div class="noqbot-modalbox modal fade" id="noqbot-feedback" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="noqbot-modal-content">
            <div class="noqbot-formarea">
                <div class="noqbot-border-heading">
                    <h3>Обратная связь</h3>
                </div>
                <form class="noqbot-loginform" method="post">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="userName" class="form-control" placeholder="Имя отправителя">
                        </div>
                        <div class="form-group">
                            <input type="text" name="userName/email" class="form-control" placeholder="Электронная почта">
                        </div>
                        <div class="form-group">
                            <input type="text" name="userName/email" class="form-control" placeholder="Контактный телефон">
                        </div>
                        <div class="form-group">
                            <input type="text" required="" placeholder="Тема сообщения" class="form-control" name="contact[name]">
                        </div>
                        <div class="form-group">
                            <textarea required placeholder="Текст сообщения" name="contact[message]" style="position: relative; width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="form-group">
                            <button id="closeButton" class="noqbot-btn noqbot-btn-lg" data-dismiss="modal">Отмена</button>
                        </div>
                        <div class="form-group">
                            <button class="noqbot-btn noqbot-btn-lg" type="submit">Отправить</button>
                        </div>
                        <div class="noqbot-description">
                            <p><a href="#"></a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->yieldContent('jsfooter'); ?>
</body>
</html>
