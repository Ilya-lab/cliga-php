<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Лига')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php echo e(asset('css/style-general.css').'?v='.config('app.version')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/style-1.css').'?v='.config('app.version')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/scrypt-1.js').'?v='.config('app.version')); ?>" type="text/javascript"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/fonts/style.css').'?v='.config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/fonts/weather-icons.min.css').'?v='.config('app.version')); ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Russo+One&amp;subset=latin-ext" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo e(asset('/images/favicon.ico')); ?>" type="image/vnd.microsoft.icon" />
    <meta property="og:url" content="<?php echo e(url('/')); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta property="og:image" content="<?php echo e(url('/')); ?>" />

    <meta itemprop="og:headline" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta itemprop="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
</head>

<body>
<nav class="navbar-links">
    <div class="container-fluid nav-container">
        <div class="row">
            <ul class="top-nav hidden-xs hidden-sm">
                <li class="mlsz-link">
                    <a href="<?php echo e(env('APP_URL')); ?>"><img src="<?php echo e(asset('/images/logo_small.png')); ?>"></a>
                </li>
                <li class="dropdown desktop-link">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Лига <span class="caret"></span></a>
                    <div class="dropdown-menu all-links">
                        <div class="col-md-2 main-col">
                            <img src="<?php echo e(asset('/images/logo2.png')); ?>" alt="Корпоративная лига">
                            <h5><a href="/">Контакты</a></h5>
                            <div>Телефон: <a href="tel://+7 (495) 226-85-27"><strong>+7 (495) 226-85-27</strong></a></div>
                            <div>E-mail: <a href="mailto:org@cliga.ru"><strong>org@cliga.ru</strong></a></div>
                        </div>
                        <div class="col-md-2">
                            <h5>Лига</h5>
                            <ul>
                                <li><a href="/">О нас</a></li>
                                <li><a href="/">Руководство</a></li>
                                <li><a href="/">Наблюдательный совет</a></li>
                                <li><a href="/">Совет капитанов</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>СМИ</h5>
                            <ul>
                                <li><a href="/">СМИ о нас</a></li>
                                <li><a href="/">Интервью</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Партнёры</h5>
                            <ul>
                                <li><a href="/">Спонсоры</a></li>
                                <li><a href="/">Партнёры</a></li>
                                <li><a href="/">Информационные партнёры</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Другое</h5>
                            <ul>
                                <li><a href="/">Портфолио</a></li>
                                <li><a href="/">Рекомендации и награды</a></li>
                                <li><a href="/">Благотворительность</a></li>
                                <li><a href="/">Оборудование</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="dropdown desktop-link">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Футбол<span class="caret"></span></a>
                    <div class="dropdown-menu all-links">
                        <div class="col-md-2 main-col">
                            <img src="<?php echo e(asset('/images/logo2.png')); ?>" alt="Корпоративная лига">
                            <h5><a href="/">Футбол</a></h5>
                            <div>Текущий турнир: <a href="/"><strong>Суперсерия 2020</strong></a></div>
                        </div>
                        <div class="col-md-2">
                            <h5>Чемпионаты</h5>
                            <ul>
                                <li><a href="/">Суперсерия</a></li>
                                <li><a href="/">Серия 5х5</a></li>
                                <li><a href="/">Серия А</a></li>
                                <li><a href="/">Серия В</a></li>
                                <li><a href="/">Серия С</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Кубки</h5>
                            <ul>
                                <li><a href="/">Суперсерия</a></li>
                                <li><a href="/">Серия 5х5</a></li>
                                <li><a href="/">Серия А</a></li>
                                <li><a href="/">Серия В</a></li>
                                <li><a href="/">Серия С</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Лучшие игроки</h5>
                            <ul>
                                <li><a href="/">Суперсерия</a></li>
                                <li><a href="/">Серия 5х5</a></li>
                                <li><a href="/">Серия А</a></li>
                                <li><a href="/">Серия В</a></li>
                                <li><a href="/">Серия С</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Зал Славы</h5>
                            <ul>
                                <li><a href="/">Суперсерия</a></li>
                                <li><a href="/">Серия 5х5</a></li>
                                <li><a href="/">Серия А</a></li>
                                <li><a href="/">Серия В</a></li>
                                <li><a href="/">Серия С</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <h5>Рейтинги</h5>
                            <ul>
                                <li><a href="/">Суперсерия</a></li>
                                <li><a href="/">Серия 5х5</a></li>
                                <li><a href="/">Серия А</a></li>
                                <li><a href="/">Серия В</a></li>
                                <li><a href="/">Серия С</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="http://basket.cliga.ru" about="_blank">Баскетбол</a></li>
                <li><a href="/">Волейбол</a></li>
                <li><a href="/">Хоккей</a></li>
                <li><a href="/">Настольный теннис</a></li>
                <li><a href="/">Дартс</a></li>
                <li><a href="/">Кёрлинг</a></li>
            </ul>
            <ul class="top-right-buttons">
                <li><a href="tel://+7 495 226-85-27"><i class="icon-mobile-phone"></i><strong> +7 495 226-85-27</strong></a>
                </li>
                <li id="nav-search" class="hidden-sm hidden-xs" style="">
                    <button type="button" onclick="searchmodalindul();">
                        <i class="icon-search" aria-hidden="true"></i> Поиск
                    </button>
                </li>
                <li id="nav-search-mobile" class="hidden-md hidden-lg" style="">
                    <button type="button" onclick="searchmodalindul();">
                        <i class="icon-search" aria-hidden="true"></i> Поиск
                    </button>
                </li>
                <li class="langs">#Корпоративнаялига #corliga #cliga
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<nav class="navbar navbar-default  ">
    <div class="container nav-container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="mobile-nav-btn">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('/images/logo.png')); ?>">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/"  class="main-link">Новости</a></li>
                <li><a href="/"  class="main-link">Аренда</a></li>
                <li><a href="/"  class="main-link">Спортивные праздники</a></li>
                <li><a href="/"  class="main-link">Календарь</a></li>
                <li><a href="/"  class="main-link">Экипировка</a></li>
                <li><a href="/"  class="main-link">Видео</a></li>
                <li><a href="/"  class="main-link">Фотогалерея</a></li>
                <li><a href="/"  class="main-link">Трансляция</a></li>
            </ul>
        </div>
    </div>
</nav>

<nav id="mobile-nav">
    <div class="container-fluid">
        <div class="row">
            <div class="mobile-nav-header col-sm-12 col-xs-12">
                <a class="navbar-brand" href="https://www.mlsz.hu">
                    <img src="<?php echo e(asset('/images/logo.png')); ?>">
                </a>
                <button id="mobile-nav-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
            </div>
            <div class="mobile-nav-links col-sm-12 col-xs-12">
                <div class="row">
                    <ul class="mobile-links">
                        <li class="dropdown">
                            <a id="dLabel2" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/valogattotak-icon.png" alt="Válogatottak"></div>Válogatottak<span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="#" class="dropdown-title"><span class="left-caret"></span> Válogatottak</a></li>
                                <li><a href="https://valogatott.mlsz.hu">Főoldal</a></li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi A válogatott<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/meccsek">Meccsek & eredmények</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/keret">Keret</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/naptar&valogatottak=1">Naptár</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Női A válogatott<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/noi-a-valogatott">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/noi-a-valogatott/hirek">Hírek</a></li>

                                        <li><a href="https://valogatott.mlsz.hu/noi-a-valogatott/keret">Keret</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/noi-a-valogatott/galeria">Galériák</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U21<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u21-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u21-ferfi/hirek">Hírek</a></li>

                                        <li><a href="https://valogatott.mlsz.hu/u21-ferfi/keret">Keret</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U19<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi/meccsek">Meccsek & eredmények</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi/keret">Keret</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-ferfi/naptar&ev=2019&valogatottak=15">Naptár</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U18<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi/meccsek">Meccsek & eredmények</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi/keret">Keret</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u18-ferfi/naptar&ev=2019&valogatottak=14">Naptár</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U17<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi/meccsek">Meccsek & eredmények</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi/keret">Keret</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-ferfi/naptar&ev=2019&valogatottak=13">Naptár</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U16<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u16-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u16-ferfi/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u16-ferfi/meccsek">Meccsek & eredmények</a></li>

                                        <li><a href="https://valogatott.mlsz.hu/u16-ferfi/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u16-ferfi/naptar&ev=2019&valogatottak=12">Naptár</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Férfi U15<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u15-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u15-ferfi/hirek">Hírek</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u15-ferfi/meccsek">Meccsek & eredmények</a></li>

                                        <li><a href="https://valogatott.mlsz.hu/u15-ferfi/galeria">Galériák</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u15-ferfi/naptar&ev=2019&valogatottak=11">Naptár</a></li>
                                    </ul>
                                </li>

                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Női U19<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u19-noi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u19-noi/hirek">Hírek</a></li>



                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Női U17<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/u17-noi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/u17-noi/hirek">Hírek</a></li>


                                        <li><a href="https://valogatott.mlsz.hu/u17-noi/galeria">Galériák</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Futsal Válogatott<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://valogatott.mlsz.hu/futsal-ferfi">Főoldal</a></li>
                                        <li><a href="https://valogatott.mlsz.hu/futsal-ferfi/hirek">Hírek</a></li>

                                        <li><a href="https://valogatott.mlsz.hu/futsal-ferfi/keret">Keret</a></li>

                                    </ul>
                                </li>

                            </ul>
                        </li>


                        <li class="dropdown">
                            <a id="dLabel3" role="button"  class="main-drop-btn mobile-drop-btn" data-target="#" href="http://adatbank.mlsz.hu">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/meccscenter-icon.png" alt="Meccscenter"></div>Meccscenter<span class="caret-border"><span class="right-caret"></span></span>
                            </a>

                        </li>


                        <li class="dropdown">
                            <a id="dLabel4" role="button"  class="main-drop-btn mobile-drop-btn" data-target="#" href="https://meccsjegy.mlsz.hu">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/jegy-icon.png" alt="Meccsjegy"></div>Meccsjegy <span class="caret-border"><span class="right-caret"></span></span>
                            </a>

                        </li>


                        <li class="dropdown">
                            <a id="dLabel4" role="button"  class="main-drop-btn mobile-drop-btn" data-target="#" href="https://szurkoloiklub.mlsz.hu">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/szurkolo-icon.png" alt="Szurkolói klub"></div>Szurkolói klub <span class="caret-border"><span class="right-caret"></span></span>
                            </a>

                        </li>


                        <li class="dropdown">
                            <a id="dLabel4" role="button"  class="main-drop-btn mobile-drop-btn" data-target="#" href="http://webshop.mlsz.hu">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/webshop-icon.png" alt="Webshop"></div>Webshop <span class="caret-border"><span class="right-caret"></span></span>
                            </a>

                        </li>


                        <li class="dropdown">
                            <a id="dLabel4" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/mlsz_ikonok_szovetseg.png" alt="Szövetség"></div>Szövetség <span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="#" class="dropdown-title"><span class="left-caret"></span> Szövetség</a></li>
                                <li><a href="https://szovetseg.mlsz.hu">Főoldal</a></li>                                <li><a href="https://produktivitas.mlsz.hu">Produktivitás</a></li>                                <li><a href="https://futballszakma.mlsz.hu">Futballszakma</a></li>                                <li><a href="https://jatekvezetes.mlsz.hu">Játékvezetés</a></li>                                <li><a href="https://felnottkepzes.mlsz.hu">Felnőttképzés</a></li>                                <li><a href="http://portal.coacheducation.hu">Edzőképzés</a></li>                                <li><a href="https://futballtortenelem.mlsz.hu">Futballtörténelem</a></li>                                <li><a href="https://grassroots.mlsz.hu">Grassroots</a></li>                                <li><a href="https://szocialis-programok.mlsz.hu">Szociális program</a></li>                                <li><a href="https://bozsikprogram.mlsz.hu">Bozsik Program</a></li>                                <li><a href="https://fairplaycup.mlsz.hu">Fairplay Cup</a></li>                                                            </ul>
                        </li>





                        <li class="dropdown">
                            <a id="dLabel4" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/mlsz_ikonok_igazgatosag.png" alt="Igazgatóságok"></div>Igazgatóságok <span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="#" class="dropdown-title"><span class="left-caret"></span> Igazgatóságok</a></li>
                                <li><a href="https://bacs.mlsz.hu">Bács-Kiskun</a></li>                                <li><a href="https://baranya.mlsz.hu">Baranya</a></li>                                <li><a href="https://bekes.mlsz.hu">Békés</a></li>                                <li><a href="https://borsod.mlsz.hu">Borsod-A-Z</a></li>                                <li><a href="https://budapest.mlsz.hu">Budapest</a></li>                                <li><a href="https://csongrad.mlsz.hu">Csongrád</a></li>                                <li><a href="https://fejer.mlsz.hu">Fejér</a></li>                                <li><a href="https://gyor.mlsz.hu">Győr-M-S</a></li>                                <li><a href="https://hajdu-bihar.mlsz.hu">Hajdú-Bihar</a></li>                                <li><a href="https://heves.mlsz.hu">Heves</a></li>                                <li><a href="https://szolnok.mlsz.hu">Jász-N-Sz</a></li>                                <li><a href="https://komarom.mlsz.hu">Kom-Esztergom</a></li>                                <li><a href="https://nograd.mlsz.hu">Nógrád</a></li>                                <li><a href="https://pest.mlsz.hu">Pest</a></li>                                <li><a href="https://somogy.mlsz.hu">Somogy</a></li>                                <li><a href="https://szabolcs.mlsz.hu">Szabolcs-Sz-B</a></li>                                <li><a href="https://tolna.mlsz.hu">Tolna</a></li>                                <li><a href="https://vas.mlsz.hu">Vas</a></li>                                <li><a href="https://veszprem.mlsz.hu">Veszprém</a></li>                                <li><a href="https://zala.mlsz.hu">Zala</a></li>                                                            </ul>
                        </li>


                        <li class="dropdown">
                            <a id="dLabel4" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/fejlesztes-icon.png" alt="Fejlesztések"></div>Fejlesztések <span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="#" class="dropdown-title"><span class="left-caret"></span> Fejlesztések</a></li>
                                <li><a href="https://fejlesztesek.mlsz.hu">Főoldal</a></li>                                <li><a href="https://tao-palyazatok.mlsz.hu">TAO pályázat</a></li>                                <li><a href="https://tao-ellenorzes.mlsz.hu">TAO ellenőrzés</a></li>                                <li><a href="https://palyaepites.mlsz.hu/">OPP</a></li>                                                            </ul>
                        </li>


                        <li class="dropdown">
                            <a id="dLabel2" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/adatkezeles-icon.png" alt="Adatkezelés"></div>Adatkezelés<span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="https://adatvedelem.mlsz.hu/adatbejelento-urlap">Adatbejelentő űrlap</a></li>
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dokumentumok<span class="right-caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="https://adatvedelem.mlsz.hu/dokumentumtar/adatkezelesi-tajekoztatok">Adatkezelési tájékoztatók</a></li>
                                        <li><a href="https://adatvedelem.mlsz.hu/adatbejelento-urlap">Űrlap a jogok gyakorlásához</a></li>
                                        <li><a href="https://adatvedelem.mlsz.hu/adatkezelessel-kapcsolatos-fogalmak-magyarazata">Fogalmak magyarázata</a></li>
                                        <li><a href="https://adatvedelem.mlsz.hu/altalanos-adatkezelesi-tajekoztato">Általános információk</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a id="dLabel8" role="button" data-toggle="dropdown" class="main-drop-btn mobile-drop-btn" data-target="#" href="#">
                                <div class="link-icon-box"><img src="https://www.mlsz.hu/design/kozponti-fejlec/assets/img/euro-2020-logo.png" alt="EURO2020"></div>EURO2020<span class="caret-border"><span class="right-caret"></span></span>
                            </a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="#" class="dropdown-title"><span class="left-caret"></span> EURO2020</a></li>
                                <li><a href="https://euro2020.mlsz.hu/hirek">Hírek</a></li>                                <li><a href="https://euro2020.mlsz.hu/#helyszinek">Helyszínek</a></li>                                <li><a href="https://euro2020.mlsz.hu/#percrol-percre">Percről percre</a></li>                                <li><a href="https://euro2020.mlsz.hu/#menetrend">Menetrend</a></li>                                <li><a href="https://euro2020.mlsz.hu/onkentes">Önkéntes</a></li>                                                            </ul>
                        </li>





                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade " id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input class="search-input" id="search-input" name="search-input" placeholder="Введите текст">
                <button id="search-btn1" onclick="kereses('desktop','search-input','')"><i class="icon-search" aria-hidden="true"></i> Поиск</button>
            </div>
        </div>
    </div>
</div>


<div id="mobile-search" class="hidden-md hidden-lg">
    <div class="mobile-search-header col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <img src="https://www.mlsz.hu/design/igazgatosag/assets/img/mlsz-hu-big-logo.png">
            </div>
            <div class="col-sm-6 col-xs-6">
                <span>Поиск</span>
                <button id="mobile-search-close"><i class="icon-remove" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12">
        <input class="search-input" id="search-input-mobile" name="search-input-mobile" placeholder="Введите текст">
        <button class="search-input-btn" onclick="kereses('mobil')"><i class="icon-search" aria-hidden="true"></i></button>
    </div>
</div>

<?php echo $__env->yieldContent('content'); ?>

<section id="main-sponsor-title"><div class="container"><div class="row"><h4 class="partner-title text-center">Партнёры</h4></div></div></section>
<section class="sponsors">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12 partner-column">
                <ul class="text-center">
                    <li><a class="partner-link" href="http://www.amfr.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/amfr.png')); ?>" class="partner-img" alt="АМФР"></a></li>
                    <li><a class="partner-link" href="https://mosbasket.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/fbm.png')); ?>" class="partner-img" alt="Федерация Баскетбола Москвы"></a></li>
                    <li><a class="partner-link" href="https://cbr.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/cbrf.png')); ?>" class="partner-img" alt="Банк России"></a></li>
                    <li><a class="partner-link" href="https://rossvyaz.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/rossvyaz.png')); ?>" class="partner-img" alt="Россвязь"></a></li>
                    <li><a class="partner-link" href="https://arb.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/arb.png')); ?>" class="partner-img" alt="Ассоциация Российских Банков"></a></li>
                    <li><a class="partner-link" href="https://soyuzmash.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/soyuzmash.png')); ?>" class="partner-img" alt="Союз Машиностроителей России"></a></li>
                    <li><a class="partner-link" href="http://moscow.ilovebasket.ru" target="_blank"><img src="<?php echo e(asset('/images/partners/mlbl.png')); ?>" class="partner-img" alt="Московская Любительская Баскетбольная Лига Москвы"></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="kozponti-footer-links">
    <div class="container">
        <div class="row">
            <ul class="kozponti-footer-contacts kfs-menu-sor">
                <li><strong>CLIGA.RU</strong></li>
                <li><a href="/" target="_blank">Контакты</a> |</li>
                <li><a href="/" target="_blank">Пользовательское соглашение</a></li>
            </ul>
            <ul class="kozponti-footer-social kfs-social-ikon-list">
                <li><a href="https://vk.com/corliga" target="_blank"><img src="<?php echo e(asset('/images/icons/vk.png')); ?>" class="kozponti-footer-icon" /></a></li>
                <li><a href="https://www.youtube.com/channel/UCoDhQy4pEeOOCxcxQTzjBTQ" target="_blank"><img src="<?php echo e(asset('/images/icons/youtube.png')); ?>" class="kozponti-footer-icon" /></a></li>
                <li><a href="https://instagram.com/corliga" target="_blank"><img src="<?php echo e(asset('/images/icons/instagram.png')); ?>" class="kozponti-footer-icon" /></a></li>
            </ul>
        </div>
    </div>
</section>
<footer class="kozponti-footer-end">
    <div class="container">
        <div class="row">
            <p class="text-right kfe-info">Ⓒ 2005 - <?php echo e(date('Y')); ?> Корпоративная лига™ <span class="kfe-span">&nbsp; &nbsp;</span>Все права защищены!</p>
        </div>
    </div>
</footer>









<script src="<?php echo e(asset('js/scrypt-2.js').'?v='.config('app.version')); ?>" type="text/javascript"></script>

<script>
    function sutiGetCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    var options = {
        text: 'Чтобы сделать работу с сайтом более удобной мы используем Cookie. <a href="<?php echo e(route('cookie')); ?>" target="_blank" style="color: #ffffff; font-weight: bold; text-decoration: underline;">Читать подробнее...</a>',
        btnText: 'Принять',bgColor: '#000000',textColor: '#fff',btnColor: '#071c6e',btnTextColor: '#fff',leftPadding: '0',rightPadding: '0',hideAnimation: 'fadeOut'
    };

    function cookieelfogadva() {
        document.cookie = "cookie_policy=true; expires=365; path=/";
        $('#cookie_container').slideUp();
    }
    $(function() {
        $('head').append('<style>.cookie_container { position: fixed; left: 0px; right: 0px; bottom: 0px; z-index: 100000; display: none; padding: 5px; background-color:' + options.bgColor + '; color:' + options.textColor + '; } .cookie_inner { width: 90%; margin: 0 auto; } #setCookie { float: right; padding: 5px 10px; text-decoration: none; background-color: ' + options.btnColor + '; color: ' + options.btnTextColor + '; } #setCookie:hover { background-color: #ffffff !important; color: #071c6e !important; } #infoCookie { padding-top: 5px; }</style>');
        var popup = '<div id="cookie_container" class="cookie_container"><div class="cookie_inner"><a id="setCookie" href="javascript:cookieelfogadva();">' + options.btnText + '</a><div id="infoCookie">' + options.text + '</div></div></div>';
        $(popup).prependTo('body');
        var cookie = sutiGetCookie('cookie_policy');
        if (!cookie) {
            $('#cookie_container').show();
        }
    });
</script>

</body>
</html>
