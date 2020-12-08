
<!doctype html>
<html lang="ru" dir="ltr">
<head>
    <meta property="og:site_name" content="API для системы Чемпион">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#0000ff">

    <meta charset="utf-8">
    <meta content="IE=Edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Google+Sans:400,500|Roboto:400,400italic,500,500italic,700,700italic|Roboto+Mono:400,500,700|Material+Icons">
    <link rel="stylesheet" href="<?php echo e(asset('api/css/app.css').'?v='.config('app.version')); ?>">
    <noscript>
        <link rel="stylesheet" href="<?php echo e(asset('api/css/ce_bundle.css.css').'?v='.config('app.version')); ?>">
    </noscript>
    <link rel="shortcut icon" href="<?php echo e(asset('api/images/favicon.png').'?v='.config('app.version')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('api/images/touchicon-180.png').'?v='.config('app.version')); ?>">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> &nbsp;|&nbsp; API доступа &nbsp;|&nbsp; Разработчикам</title>

    <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?> &nbsp;|&nbsp; API доступа &nbsp;|&nbsp; Разработчикам">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="675">
    <meta property="og:locale" content="en">
    <meta name="twitter:card" content="summary_large_image">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body type="reference"
      theme="cl-theme"
      class="docs"
      layout="docs"
      pending>
<devsite-progress type="indeterminate" id="app-progress"></devsite-progress>
<section class="devsite-wrapper"><devsite-header>
        <div class="devsite-header--inner">
            <div class="devsite-top-logo-row-wrapper-wrapper">
                <div class="devsite-top-logo-row-wrapper">
                    <div class="devsite-top-logo-row">
                        <button type="button" id="devsite-hamburger-menu"
                                class="devsite-header-icon-button button-flat material-icons gc-analytics-event"
                                data-category="Site-Wide Custom Events"
                                data-label="Navigation menu button"
                                visually-hidden
                                aria-label="Открыть меню">
                        </button>
                        <div class="devsite-product-name-wrapper">
                            <a href="/">
                                <div class="devsite-product-logo-container">
                                    <img class="devsite-product-logo"
                                         alt="КЛ"
                                         src="<?php echo e(asset("/api/images/logo.png")); ?>"
                                         srcset=""
                                         sizes="209px">
                                </div>
                            </a>
                            <span class="devsite-product-name">
                            <ul class="devsite-breadcrumb-list">
                                <li class="devsite-breadcrumb-item">
                                    <div class="devsite-breadcrumb-guillemet material-icons" aria-hidden="true"></div>
                                        <a href="<?php echo e(route('api_doc')); ?>" class="devsite-breadcrumb-link gc-analytics-event"
                                           data-category="Site-Wide Custom Events"
                                           data-label="Upper Header"
                                           data-value="2"> API</a>
                                 </li>
                            </ul>
                            </span>
                        </div>
                    </div>    </div>  </div>
            <div class="devsite-collapsible-section">
                <div class="devsite-header-background">
                    <div class="devsite-doc-set-nav-row">
                        <devsite-tabs class="lower-tabs">
                            <div class="devsite-tabs-wrapper">
                                <tab  >
                                    <a href="/"
                                       class="gc-analytics-event"
                                       track-type="globalNav"
                                       track-metadata-position="nav"
                                       track-metadata-eventdetail="nav"
                                       track-name=""
                                       data-category="Site-Wide Custom Events"
                                       data-label="Tab: Главная">
                                        Главная
                                    </a>
                                </tab>
                                <tab  active>
                                    <a href="<?php echo e(route('api_doc')); ?>"
                                       class="gc-analytics-event"
                                       track-type="globalNav"
                                       track-metadata-position="nav"
                                       track-metadata-eventdetail="nav"
                                       track-name=""
                                       aria-label="Справочники, selected"         data-category="Site-Wide Custom Events"
                                       data-label="Tab: Справочники">
                                        Справочники
                                    </a>
                                </tab>
                                <tab  >
                                    <a href="/home"
                                       class="gc-analytics-event"
                                       track-type="globalNav"
                                       track-metadata-position="nav"
                                       track-metadata-eventdetail="nav"
                                       track-name=""
                                       data-category="Site-Wide Custom Events"
                                       data-label="Tab: Личный кабинет">
                                        Личный кабинет
                                    </a>
                                </tab>
                            </div>
                        </devsite-tabs>


                    </div>
                </div>  </div></div>

    </devsite-header>
    <devsite-book-nav scrollbars >
        <nav class="devsite-book-nav devsite-nav nocontent">
            <div class="devsite-book-nav-wrapper">
                <div class="devsite-mobile-nav-bottom">
                    <ul class="devsite-nav-list" menu="_book">
                        <li class="devsite-nav-item"><a href="<?php echo e(route('api_doc')); ?>" class="devsite-nav-title"><span class="devsite-nav-text" tooltip>Введение</span></a></li>
                        <li class="devsite-nav-item">
                            <a href="<?php echo e(route('api_doc_sports')); ?>" class="devsite-nav-title">
                                <span class="devsite-nav-text" tooltip>Виды спорта</span>
                            </a>
                        </li>
                        <li class="devsite-nav-item">
                            <a href="<?php echo e(route('api_doc_leagues')); ?>" class="devsite-nav-title">
                                <span class="devsite-nav-text" tooltip>Лиги</span>
                            </a>
                        </li>
                        <li class="devsite-nav-item devsite-nav-expandable"><devsite-expandable-nav collapsed>
                                <a class="devsite-nav-toggle" aria-hidden="true"></a>
                                <div class="devsite-nav-title devsite-nav-title-no-path" tabindex="0" role="button">
                                    <span class="devsite-nav-text" tooltip>Сезоны</span>
                                </div>
                                <ul class="devsite-nav-section">
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_seasons')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Обзор</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_seasons_league')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Сезоны в лиге</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_seasons_all')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Все сезоны</span>
                                        </a>
                                    </li>
                                </ul>
                            </devsite-expandable-nav>
                        </li>
                        <li class="devsite-nav-item devsite-nav-expandable"><devsite-expandable-nav collapsed>
                                <a class="devsite-nav-toggle" aria-hidden="true"></a>
                                <div class="devsite-nav-title devsite-nav-title-no-path" tabindex="0" role="button">
                                    <span class="devsite-nav-text" tooltip>Соревнования</span>
                                </div>
                                <ul class="devsite-nav-section">
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_tournaments')); ?>" class="devsite-nav-title">
                                        <span class="devsite-nav-text" tooltip>Обзор</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_tournaments_all')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Все соревнования</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_tournaments_season_sport')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Соревнования по виду спорта и сезону</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_tournaments_teams')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Команды - участники</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item">
                                        <a href="<?php echo e(route('api_doc_seasons_league')); ?>" class="devsite-nav-title">
                                            <span class="devsite-nav-text" tooltip>Сезоны</span>
                                        </a>
                                    </li>
                                    <li class="devsite-nav-item devsite-nav-expandable"><devsite-expandable-nav collapsed>
                                            <a class="devsite-nav-toggle" aria-hidden="true"></a>
                                            <div class="devsite-nav-title devsite-nav-title-no-path" tabindex="0" role="button">
                                                <span class="devsite-nav-text" tooltip>Матчи</span>
                                            </div>
                                            <ul class="devsite-nav-section">
                                                <li class="devsite-nav-item">
                                                    <a href="<?php echo e(route('api_doc_matches')); ?>" class="devsite-nav-title">
                                                        <span class="devsite-nav-text" tooltip>Обзор</span>
                                                    </a>
                                                </li>
                                                <li class="devsite-nav-item">
                                                    <a href="<?php echo e(route('api_doc_matches_lastfirst')); ?>" class="devsite-nav-title">
                                                        <span class="devsite-nav-text" tooltip>Последние и ближайшие матчи</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </devsite-expandable-nav>
                                    </li>
                                </ul>
                            </devsite-expandable-nav>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </devsite-book-nav>
    <section id="gc-wrapper">
        <main role="main" class="devsite-main-content" has-book-nav has-toc>
            <devsite-toc class="devsite-nav"></devsite-toc>
            <devsite-content>
                <article class="devsite-article">
                    <article class="devsite-article-inner">
                        <div class="devsite-article-meta">
                            <?php echo $__env->yieldContent('menu'); ?>
                        </div>
                        <h1 class="devsite-page-title"><?php echo $__env->yieldContent('header'); ?></h1>
                        <section id="overview">
                            <?php echo $__env->yieldContent('content'); ?>
                        </section>

                    </article>
                </article>

                <devsite-content-footer class="nocontent">
                    <p>API для информационно-статистической системы Чемпион</p>
                </devsite-content-footer>



            </devsite-content>
        </main>
    </section>
</section>
<script>
    (function(d,e,v,s,i,t,E){d['CLDevelopersObject']=i;
        t=e.createElement(v);t.async=1;t.src=s;E=e.getElementsByTagName(v)[0];
        E.parentNode.insertBefore(t,E);})(window, document, 'script',
        '/api/js/app_loader.js?v2', '[1,"ru",null,"/js/devsite_app.js","https://www.gstatic.com/devrel-devsite/prod/v172e5dffd78b32f4b12f8112b00e940d4993af48229fac5346097b33edb0f543","https://www.gstatic.com/devrel-devsite/prod/v172e5dffd78b32f4b12f8112b00e940d4993af48229fac5346097b33edb0f543/developers","https://developers-dot-devsite-v2-prod.appspot.com",null,null,["/_pwa/developers/manifest.json","/_static/images/video-placeholder.svg","https://www.gstatic.com/devrel-devsite/prod/v172e5dffd78b32f4b12f8112b00e940d4993af48229fac5346097b33edb0f543/developers/images/favicon.png","https://fonts.googleapis.com/css?family=Google+Sans:400,500|Roboto:400,400italic,500,500italic,700,700italic|Roboto+Mono:400,500,700|Material+Icons"],1]')
</script>
</body>
</html>
