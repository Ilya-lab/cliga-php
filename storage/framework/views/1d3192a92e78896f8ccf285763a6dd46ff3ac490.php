<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Лига')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-cancel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-jquery.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('noqbot-webdesign/noqbot-responsive.css')); ?>">
    <script src="<?php echo e(asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')); ?>"></script>
    <link rel="shortcut icon" href="<?php echo e(asset('/images/favicon.ico')); ?>" type="image/vnd.microsoft.icon" />
    <meta property="og:url" content="<?php echo e(url('/')); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <meta property="og:image" content="<?php echo e(url('/')); ?>" />
    <meta itemprop="og:headline" content="<?php echo $__env->yieldContent('title'); ?>" />
    <meta itemprop="og:description" content="<?php echo $__env->yieldContent('desc'); ?>" />
    <script>
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
    </script>
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
        <div class="container">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <div class="noqbot-topbar noqbot-stratum">
                            <nav id="noqbot-topaddnav" class="noqbot-topaddnav">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#noqbot-addnavigationm-mobile">
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                                <div id="noqbot-addnavigationm-mobile" class="noqbot-addnavigationm-mobile collapse navbar-collapse">
                                    <div class="noqbot-colhalf pull-right">
                                        <nav class="noqbot-addnav">
                                            <ul>
                                                <li><a href="javascript().html" data-toggle="modal" data-target="#noqbot-login">Авторизация</a></li>
                                                <li><a href="javascript().html" data-toggle="modal" data-target="#noqbot-register">Регистрация</a></li>
                                                <li>
                                                    <div class="noqbot-cart">
                                                        <a href="javascript:void(0)" class="dropdown-toggle" id="noqbot-cartdropdown" data-toggle="dropdown">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a id="noqbot-btn-search" href="javascript:void(0)"><i class="fa fa-search"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="noqbot-colhalf">
                                        <ul class="noqbot-socialicons">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-dribbble"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <nav id="noqbot-nav" class="noqbot-nav brand-center">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#noqbot-browsing-responsive">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <strong class="noqbot-logo">
                                    <a href="index-2.html"><img src="images/logo.png" alt="image description"></a>
                                </strong>
                            </div>
                            <div id="noqbot-navigation" class="noqbot-navigation">
                                <div class="noqbot-colhalf">
                                    <ul>
                                        <li class="active">
                                            <a href="#">Лига</a>
                                            <ul class="noqbot-dropdown-menu">
                                                <li class="active"><a href="index-2.html">Пункт 1</a></li>
                                                <li><a href="index2.html">Пункт 2</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Партнеры</a>
                                            <ul class="noqbot-dropdown-menu">
                                                <li><a href="playergrid-v1.html">Пункт 1</a></li>
                                                <li><a href="playergrid-v2.html">Пункт 2</a></li>
                                                <li><a href="playerdetail.html">Пункт 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="buyticket.html">Футбол</a></li>
                                        <li>
                                            <a href="#">Баскетбол</a>
                                            <ul class="noqbot-dropdown-menu">
                                                <li><a href="matchresult.html">Пункт 1</a></li>
                                                <li><a href="matchresultdetail.html">Пункт 2</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Волейбол</a>
                                            <ul class="noqbot-dropdown-menu">
                                                <li><a href="fixtures.html">Пункт 1</a></li>
                                                <li><a href="fixturedetail.html">Пункт 2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="noqbot-colhalf">
                                    <ul>
                                        <li>
                                            <a href="#">Хоккей</a>
                                            <ul class="noqbot-dropdown-menu">
                                                <li><a href="soccermedia-1.html">Пункт 1</a></li>
                                                <li><a href="soccermedia-2.html">Пункт 2</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contactus.html">Настольный теннис</a></li>
                                        <li><a href="contactus.html">Дартс</a></li>
                                        <li><a href="contactus.html">Керлинг</a></li>
                                        <li>
                                            <a href="#"><i class=" fa fa-navicon"></i></a>
                                            <ul>
                                                <li><a href="aboutus.html">Пункт 1</a></li>
                                                <li><a href="shoplist.html">Пункт 2</a></li>
                                                <li><a href="shopgrid.html">Пункт 3</a></li>
                                                <li><a href="productsingle.html">Пункт 4</a></li>
                                                <li><a href="bloglist.html">Пункт 5</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                        <div class="noqbot-slideshow-widget noqbot-haslayout">
                            <div id="noqbot-slideshow-slider" class="noqbot-slideshow-slider noqbot-haslayout">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/1.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/2.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/3.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/4.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/5.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/6.png" alt="image description">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure class="noqbot-postimg">
                                            <img id="noqbot-slide-img" src="images/logos/7.png" alt="image description">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="background:none;">
            <div class="row">
                <div class="col-sm-12">
                    <div id="myCarousel" class="row carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <ul class="thumbnails">
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul class="thumbnails">
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="item">
                                <ul class="thumbnails">
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="noqbot-name-team-result-block" class="col-sm-2">
                                        <div class="caption-box">
                                            <p><i id="noqbot-news-clock-icon" class="fa fa-clock-o"></i>1 ТУР - 21.03.2020 18:00</p>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-home">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-home">2</h3>
                                                </div>
                                            </div>
                                            <div id="noqbot-name-team-result" class="col-sm-12">
                                                <div id="noqbot-name-team" class="col-sm-10">
                                                    <h3 class="noqbot-name-team-result-away">РОСАГРОЛИЗИНГ</h3>
                                                </div>
                                                <div id="noqbot-name-result" class="col-sm-2">
                                                    <h3 class="noqbot-name-team-result-away">2</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
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
        <div class="noqbot-stratum noqbot-footerinfobox">
            <div class="noqbot-bgboxone"></div>
            <div class="noqbot-bgboxtwo"></div>
            <div class="noqbot-footerinfo">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-xs-12">
                            <div class="noqbot-footercol">
                                <div class="noqbot-posttitle">
                                    <h3>Партнеры</h3>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="noqbot-toprated">
                                        <ul>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/1.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Ассоциация мини-футбола России</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/2.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Федерация Баскетбола Москвы</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/3.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Банк России</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/4.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Россвязь</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="noqbot-toprated">
                                        <ul>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/5.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Союз Машиностроителей России</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/6.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Ассоциация российских банков</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col-sm-3 col-xs-12">
                                                    <figure>
                                                        <a href="#">
                                                            <img src="images/logos/7.png" alt="image description">
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <div class="noqbot-productcontent">
                                                        <h4><a href="#">Межрегиональная любительская баскетбольная лига</a></h4>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="noqbot-footercol">
                                <div class="noqbot-posttitle">
                                    <h3>Контакты</h3>
                                </div>
                                <div class="noqbot-stratum">
                                    <strong class="noqbot-logo">
                                        <a href="#">
                                            <img src="images/logo.png" alt="image description">
                                        </a>
                                    </strong>
                                </div>
                                <div class="noqbot-description">
                                    <p>Центральный офис - г. Москва</p>
                                </div>
                                <ul class="noqbot-contactinfo">
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <address>Адрес: г. Москва, Сущевский вал, д.56, c.5 (м. Марьина роща, м. Рижская)</address>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>
                                        <a href="">org@cliga.ru</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <span>Оргкомитет: +7 (495) 226-85-27</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <span>Аренда: +7 (495) 226-85-27</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <address>По вопросам проведения мероприятий обращайтесь по тел.: +7 (495) 226-85-27</address>
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
                            <input type="search" class="form-control" placeholder="keyword">
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
                            <input type="text" name="userName/email" class="form-control" placeholder="username/email">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="password">
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
                            <button class="noqbot-btn noqbot-btn-lg" type="submit">Login Now</button>
                        </div>
                        <div class="noqbot-description">
                            <p>Don't have an account? <a href="#">Signup</a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="noqbot-logintype">
                <div class="noqbot-border-heading">
                    <h3>Авторизация с помощью сервисов</h3>
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
</div>
<div class="noqbot-modalbox modal fade" id="noqbot-register" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="noqbot-modal-content">
            <div class="noqbot-formarea">
                <div class="noqbot-border-heading">
                    <h3>Signup</h3>
                </div>
                <form class="noqbot-loginform" method="post">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="userName" class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="email">
                        </div>
                        <div class="form-group">
                            <div class="noqbot-note">
                                <i class="fa fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="noqbot-btn noqbot-btn-lg" type="submit"></button>
                        </div>
                        <div class="noqbot-description">
                            <p><a href="#"></a></p>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="noqbot-logintype">
                <div class="noqbot-border-heading">
                    <h3></h3>
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
</div>
<?php echo $__env->yieldContent('jsfooter'); ?>
</body>
</html>
