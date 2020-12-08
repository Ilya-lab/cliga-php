<?php $__env->startSection('title'); ?>Корпоративная лига<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="nav-plus-matches">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 owl-carousel owl-theme">
                    <?php
                    $indx = 0;
                    $fl = false;
                    ?>
                    <?php $__currentLoopData = $lenta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        if(($match->status_id == 1) || (!$fl && $match->status_id == 2)) {
                            $indx = $loop->index; $fl = true;
                        }
                        ?>
                        <div class="item <?php if($match->status_id == 1): ?> active-match <?php endif; ?>">
                            <div class="event">
                                <div class="event-container" style="position: relative;">
                                    <div class="pull-left event-date"><?php if($match->dt): ?><?php echo e(date('d M   H:i', strtotime($match->dt))); ?><?php endif; ?></div>
                                    <div class="pull-right event-date"><?php echo e($match->tour); ?></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="event-place style-text-dot">
                                    <i class="fa fa-futbol-o" aria-hidden="true"></i> <?php echo e($match->championat); ?> <i class="fa fa-map-marker"></i> <?php echo e($match->arena); ?>

                                </div>
                                <table class="next-match-table">
                                    <tbody>
                                    <tr>
                                        <td valign="middle" class="team-col text-right team-sign" scope="row">
                                           <?php echo e($match->home); ?>

                                        </td>
                                        <td>
                                            <?php if($match->home_logo): ?>
                                                <img src="<?php echo e($match->home_logo); ?>" alt="<?php echo e($match->home_name); ?>" class="team-flag img-circle">
                                            <?php endif; ?>
                                        </td>
                                        <td valign="middle" scope="row" class="time-td team-sign">
                                                <a href="<?php echo e(route('match', [$match->championat_url, $match->match_id])); ?>" style="color: #ffffff;" target="_blank"><?php if($match->status_id > 0): ?> <?php echo e($match->home_score.'-'.$match->away_score); ?> <?php else: ?> -<?php endif; ?></a>
                                        </td>
                                        <td valign="middle" class="team-col" scope="row">
                                                <?php if($match->away_logo): ?>
                                                <img src="<?php echo e($match->away_logo); ?>" alt="<?php echo e($match->away_name); ?>" class="team-flag img-circle">
                                                <?php endif; ?>
                                        </td>
                                        <td valign="middle" class="team-col text-left team-sign" scope="row">
                                            <?php echo e($match->away); ?>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="position: relative;margin-bottom: 10px;"><span class="status-match"><?php echo e($match->status); ?></span></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            nav: false,
            startPosition: <?php echo e($indx); ?>,
            center: true,
            navText: ["<i class='icon-left' aria-hidden='true'></i>", "<i class='icon-right' aria-hidden='true'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                480 : {
                    items: 2
                },
                768 : {
                    items: 5
                }
            }
        });

    </script>

    <script type="text/javascript">
        window.addeventasync = function() {
            addeventatc.settings({
                appleical: {
                    show: true,
                    text: "Apple naptár"
                },
                google: {
                    show: true,
                    text: "Google naptár<em>(online)</em>"
                },
                outlook: {
                    show: true,
                    text: "Outlook"
                },
                outlookcom: {
                    show: true,
                    text: "Outlook.com <em>(online)</em>"
                },
                yahoo: {
                    show: true,
                    text: "Yahoo <em>(online)</em>"
                }
            });
        };

    </script>

    <script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
    <section id="main-hl-news" class="news">
        <div class="container-fluid">
            <div class="row">
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($loop->first): ?>
                        <div class="col-md-6 col-sm-12 col-xs-12 big-main-news nopadding">
                            <div class="img-container">
                                <a href="<?php echo e(route('news', $nn->url)); ?>">
                                    <div class="img-filter"></div>
                                    <img src="<?php echo e($nn->image2); ?>" class="img-responsive" alt="<?php echo e($nn->title); ?>">
                                    <div class="img-caption">
                                        <span class="news-tag"><?php echo e($nn->desc); ?></span>
                                        <h2><?php echo e($nn->title); ?></h2>
                                        <p class="news-date"><?php echo e(date('d.m.Y,   H:i', strtotime($nn->date))); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($loop->index == 1): ?>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                    <?php endif; ?>
                    <?php if($loop->index != 0): ?>
                    <div class="col-md-6 col-sm-6 col-xs-12 small-main-news nopadding">
                        <div class="img-container">
                            <a href="<?php echo e(route('news', $nn->url)); ?>">
                                <div class="img-filter"></div>
                                <img src="<?php echo e($nn->image1); ?>" class="img-responsive" alt="<?php echo e($nn->title); ?>">
                                <div class="img-caption">
                                    <span class="news-tag"><?php echo e($nn->desc); ?></span>
                                    <h3><?php echo e($nn->title); ?></h3>
                                    <p class="news-date"><?php echo e(date('d.m.Y,   H:i', strtotime($nn->date))); ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($loop->last): ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <section id="tabellak-list">
        <div class="container">
            <div class="row">
                <h2 class="section-title col-md-12 col-sm-12 col-xs-12"><i class="icon-gool"></i>Соревнования</h2>
            </div>
        </div>
    </section>


    <iframe src="https://szurkoloiklub.mlsz.hu/widget/standings" id="iframe-standings" width="100%" height="650" frameBorder="0"></iframe>

    <SCRIPT LANGUAGE="JavaScript">
        // jQuery esetén
        /*$(window).on("message", function(e) {
            var data = e.originalEvent.data;
            $('iframe[src^="' + data.location + '"]').css('height', data.height + 'px');
        });*/

        // Natív JS esetén
        window.addEventListener("message", function(e){
            var data = e.data;
            document.querySelectorAll('iframe[src^="' + data.location + '"]').forEach(function(iFrameItem){
                iFrameItem.style.height = data.height + 'px';
            });
        });
    </SCRIPT>



    <section id="video-head">
        <div class="container">
            <div class="row">
                <h2 class="col-md-12 col-xs-12 main-title"><i class="icon-play"></i> Видео</h2>
            </div>
        </div>
    </section>
    <section id="videos">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="big-img-video">
                        <a href="https://www.youtube.com/embed/XkZAmhjIkJo" class="youtube cboxElement">
                            <img src="https://i.ytimg.com/vi/XkZAmhjIkJo/maxresdefault.jpg" alt="DVTK – Ferencvárosi TC | 0-1 | (0-1) | OTP Bank Liga | 16. forduló | MLSZTV">
                            <div class="shadow"></div>
                            <i class="icon-play" aria-hidden="true"></i>
                            <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            <div class="img-overlay style-text-dot">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-16 18:15:01</p>
                                <h2>DVTK – Ferencvárosi TC | 0-1 | (0-1) | OTP Bank Liga | 16. forduló | MLSZTV</h2>
                                <p>2019.12.15. OTP Bank Liga, 16. forduló
                                    DVTK – Ferencvárosi TC | 0-1 | (0-1) |
                                    összefoglaló

                                    Iratkozz fel az MLSZ TV csatornájára: http://bit.ly/2EsS9It

                                    Kövess minket itt is::
                                    Facebook: https://www.facebook.com/magyarlabdarugoszovetseg
                                    Instagram: https://www.instagram.com/mlsztv/
                                    Twitter: https://twitter.com/mlszhivatalos
                                    Web: https://www.mlsz.hu/</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-xs-12">
                    <div class="row">
                        <div class="small-img-video col-lg-12 col-md-6 col-xs-12">
                            <div class="img-container">
                                <a class="youtube cboxElement" href="https://www.youtube.com/embed/JY0awT_1R7I"><img src="https://i.ytimg.com/vi/JY0awT_1R7I/maxresdefault.jpg" alt="Kisvárda Master Good – MOL Fehérvár FC | 0-2 | (0-1) | OTP Bank Liga | 16. forduló | MLSZTV">
                                    <div class="shadow"></div>
                                    <i class="icon-play" aria-hidden="true"></i>
                                </a>
                                <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            </div>
                            <div class="caption">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-15 19:00:02</p>
                                <h5><a href="https://www.youtube.com/embed/JY0awT_1R7I" class="youtube cboxElement">Kisvárda Master Good – MOL Fehérvár FC | 0-2 | (0-1) | OTP Bank Liga | 16. forduló | MLSZTV</a></h5>
                            </div>
                        </div>
                        <div class="small-img-video col-lg-12 col-md-6 col-xs-12">
                            <div class="img-container">
                                <a class="youtube cboxElement" href="https://www.youtube.com/embed/IMUcbWOL7w8"><img src="https://i.ytimg.com/vi/IMUcbWOL7w8/maxresdefault.jpg" alt="Puskás Akadémia FC – ZTE FC | 0-1 | (0-0) | OTP Bank Liga | 16. forduló | MLSZTV">
                                    <div class="shadow"></div>
                                    <i class="icon-play" aria-hidden="true"></i>
                                </a>
                                <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            </div>
                            <div class="caption">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-15 18:30:00</p>
                                <h5><a href="https://www.youtube.com/embed/IMUcbWOL7w8" class="youtube cboxElement">Puskás Akadémia FC – ZTE FC | 0-1 | (0-0) | OTP Bank Liga | 16. forduló | MLSZTV</a></h5>
                            </div>
                        </div>
                        <div class="small-img-video col-lg-12 col-md-6 col-xs-12">
                            <div class="img-container">
                                <a class="youtube cboxElement" href="https://www.youtube.com/embed/JZF5KcIwjeA"><img src="https://i.ytimg.com/vi/JZF5KcIwjeA/maxresdefault.jpg" alt="Paksi FC – Mezőkövesd Zsóry FC | 1-0 | (1-0) | OTP Bank Liga | 16. forduló | MLSZTV">
                                    <div class="shadow"></div>
                                    <i class="icon-play" aria-hidden="true"></i>
                                </a>
                                <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            </div>
                            <div class="caption">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-15 18:30:01</p>
                                <h5><a href="https://www.youtube.com/embed/JZF5KcIwjeA" class="youtube cboxElement">Paksi FC – Mezőkövesd Zsóry FC | 1-0 | (1-0) | OTP Bank Liga | 16. forduló | MLSZTV</a></h5>
                            </div>
                        </div>
                        <div class="small-img-video col-lg-12 col-md-6 col-xs-12">
                            <div class="img-container">
                                <a class="youtube cboxElement" href="https://www.youtube.com/embed/2tEnq46zMmY"><img src="https://i.ytimg.com/vi/2tEnq46zMmY/maxresdefault.jpg" alt="Kaposvári Rákóczi FC – DVSC | 4-1 | (2-0) | OTP Bank Liga | 16. forduló | MLSZTV">
                                    <div class="shadow"></div>
                                    <i class="icon-play" aria-hidden="true"></i>
                                </a>
                                <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            </div>
                            <div class="caption">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-15 18:30:00</p>
                                <h5><a href="https://www.youtube.com/embed/2tEnq46zMmY" class="youtube cboxElement">Kaposvári Rákóczi FC – DVSC | 4-1 | (2-0) | OTP Bank Liga | 16. forduló | MLSZTV</a></h5>
                            </div>
                        </div>
                        <div class="small-img-video col-lg-12 col-md-6 col-xs-12">
                            <div class="img-container">
                                <a class="youtube cboxElement" href="https://www.youtube.com/embed/zjlpsMMnOE0"><img src="https://i.ytimg.com/vi/zjlpsMMnOE0/maxresdefault.jpg" alt="Budapest Honvéd – Újpest FC | 0-0 | (0-0) | OTP Bank Liga | 16. forduló | MLSZTV">
                                    <div class="shadow"></div>
                                    <i class="icon-play" aria-hidden="true"></i>
                                </a>
                                <span class="news-tag ferfi-bg ferfi-color">MLSZ</span>
                            </div>
                            <div class="caption">
                                <p class="news-time"><i class="icon-date" aria-hidden="true"></i> 2019-12-15 18:30:04</p>
                                <h5><a href="https://www.youtube.com/embed/zjlpsMMnOE0" class="youtube cboxElement">Budapest Honvéd – Újpest FC | 0-0 | (0-0) | OTP Bank Liga | 16. forduló | MLSZTV</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="video-btn">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><a href="/videok" class="box-btn box-btn-big">Ещё видео <i class="icon-right" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </section>
    <section id="fanclub-section">
        <div class="container">
            <div class="row">
                <div class="col-md-5" style="padding-bottom: 25px;">
                    <h2><span>#</span>CSAKEGYÜTT</h2>
                    <h4>Szurkolói klub</h4>
                    <p><strong>LEGYÉL TE IS VÁLOGATOTT SZURKOLÓ!</strong> &nbsp;
                        Regisztrálj a Futball- vagy Klubkártyáddal az MLSZ Szurkolói Klubba, és használd ki a kedvezményeket a magyar válogatott hazai mérkőzéseire vagy nyerj különleges nyereményeket a klub promócióin! Rendszeres hírlevelünkben a magyar labdarúgás legfrissebb híreit és a válogatottakkal kapcsolatos exkluzív tartalmainkat olvashatod.</p>
                    <a href="https://szurkoloiklub.mlsz.hu" target="_blank" class="green-btn btn">Regisztrálok a szurkolói klubba</a>
                </div>
                <div class="col-md-7">
                    <img src="/design/kozpont/assets/img/magyar-mez.png?12" alt="Magyar mez" id="hun-mez">
                </div>
            </div>
        </div>
    </section><div id="site-219">
        <section class="produktivitas-fejlec" style="background: url('/design/szovetseg/assets/produktivitas/produktivitas_02.png');">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div style="display: inline-block;">
                            <img src="/design/szovetseg/assets/produktivitas/produktivitasi_rendszer_felirat.png" class="prodkep" />
                            <div class="prod-szoveg">A Magyar Labdarúgó Szövetség egyik legfőbb célja az, hogy minél többen focizzanak rendszeresen, és legyen minél több saját nevelésű, hazai játékos a profi csapatokban. A szövetség egy új rendszer bevezetése mellett döntött, melynek neve Produktivitási rendszer.</div>
                            <a href="https://produktivitas.mlsz.hu" target="_blank" class="prod-gomb prod-gomb1">Bővebben</a>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12 mmt-20">
                        <img src="/adat/pagerow/189/gyorskep/nagykep/produktivitas_01-1.png" class="prodkep" />
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section id="webshop">
        <div class="container">
            <div class="row">
                <h2 class="col-md-12 col-xs-12 main-title"><i class="icon-cart"></i> Магазин</h2>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="webshop-panel">
                        <div style="border: solid 1px #cccccc; text-align: center;">
                            <img src="https://webshop.mlsz.hu/images/products/hivatalos-valogatott-mez/97055.jpg" alt="Hivatalos válogatott mez (piros, gyermek méret) 2019" style="width: auto; height: 250px;" />
                        </div>
                        <h4 class="style-text-dot">Hivatalos válogatott mez (piros, gyermek méret) 2019</h4>
                        <p class="price">Ár: <strong>21.990 Ft</strong></p>
                        <a href="https://webshop.mlsz.hu/product/4689-hivatalos-valogatott-mez-piros-gyermek-meret-2019" target="_blank" class="webshop-btn">Vásárlás</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="webshop-panel">
                        <div style="border: solid 1px #cccccc; text-align: center;">
                            <img src="https://webshop.mlsz.hu/images/products/valogatott-szurkoloi-mez/97015.jpg" alt="Válogatott szurkolói mez" style="width: auto; height: 250px;" />
                        </div>
                        <h4 class="style-text-dot">Válogatott szurkolói mez</h4>
                        <p class="price">Ár: <strong>7.990 Ft</strong></p>
                        <a href="https://webshop.mlsz.hu/product/4667-valogatott-szurkoloi-mez" target="_blank" class="webshop-btn">Vásárlás</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="webshop-panel">
                        <div style="border: solid 1px #cccccc; text-align: center;">
                            <img src="https://webshop.mlsz.hu/images/products/hivatalos-valogatott-mez/97054.jpg" alt="Hivatalos válogatott mez (piros) 2019" style="width: auto; height: 250px;" />
                        </div>
                        <h4 class="style-text-dot">Hivatalos válogatott mez (piros) 2019</h4>
                        <p class="price">Ár: <strong>27.990 Ft</strong></p>
                        <a href="https://webshop.mlsz.hu/product/4688-hivatalos-valogatott-mez-piros-2019" target="_blank" class="webshop-btn">Vásárlás</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="webshop-panel">
                        <div style="border: solid 1px #cccccc; text-align: center;">
                            <img src="https://webshop.mlsz.hu/images/products/emlekjegy/97073.jpg" alt="Puskás Aréna nyitómérkőzés emlékjegy" style="width: auto; height: 250px;" />
                        </div>
                        <h4 class="style-text-dot">Puskás Aréna nyitómérkőzés emlékjegy</h4>
                        <p class="price">Ár: <strong>1.490 Ft</strong></p>
                        <a href="https://webshop.mlsz.hu/product/4690-puskas-arena-nyitomerkozes-emlekjegy" target="_blank" class="webshop-btn">Vásárlás</a>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <a href="http://webshop.mlsz.hu" target="_blank" class="box-btn box-btn-big">Összes termék <i class="icon-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </section>
    <section id="counties">
        <div class="container">
            <div class="row">
                <h2 class="col-md-12 col-xs-12 main-title"><i class="icon-gool"></i> Megyei igazgatóságok</h2>
                <ul class="county-list col-md-12 col-xs-12">
                    <li class="county-logo"><a href="https://bacs.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/BacsKiskun.png" title="Bács-Kiskun megye" alt="Bács-Kiskun megye"></a></li>
                    <li class="county-logo"><a href="https://baranya.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/mlszbaranya_dokba.jpg" title="Baranya megye" alt="Baranya megye"></a></li>
                    <li class="county-logo"><a href="https://bekes.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Bekes.png" title="Békés megye" alt="Békés megye"></a></li>
                    <li class="county-logo"><a href="https://budapest.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/blsz_logo.jpg" title="Budapesti Igazgatóság" alt="Budapesti Igazgatóság"></a></li>
                    <li class="county-logo"><a href="https://borsod.mlsz.hu" class="active"><img src="/design/igazgatosag/assets/img/cimer/Borsod.png" title="Borsod megye" alt="Borsod megye"></a></li>
                    <li class="county-logo"><a href="https://csongrad.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/csongrad.jpg" title="Csongrád megye" alt="Csongrád megye"></a></li>
                    <li class="county-logo"><a href="https://fejer.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Fejer.png" title="Fejér megye" alt="Fejér megye"></a></li>
                    <li class="county-logo"><a href="https://gyor.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/GyorSopron.png" title="Győr-Moson-Sopron megye" alt="Győr-Moson-Sopron megye"></a></li>
                    <li class="county-logo"><a href="https://hajdu-bihar.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/HajduBihar.png" title="Hajdú-Bihar megye" alt="Hajdú-Bihar megye"></a></li>
                    <li class="county-logo"><a href="https://heves.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/heves.png" title="Heves megye" alt="Heves megye"></a></li>
                    <li class="county-logo"><a href="https://szolnok.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/JaszNagykunSzolnok.png" title="Jász-Nagykun-Szolnok megye" alt="Jász-Nagykun-Szolnok megye"></a></li>
                    <li class="county-logo"><a href="https://komarom.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Komarom.png" title="Komárom-Esztergom megye" alt="Komárom-Esztergom megye"></a></li>
                    <li class="county-logo"><a href="https://nograd.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Nograd.png" title="Nógrád megye" alt="Nógrád megye"></a></li>
                    <li class="county-logo"><a href="https://pest.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Pest.png" title="Pest megye" alt="Pest megye"></a></li>
                    <li class="county-logo"><a href="https://somogy.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Somogy.png" title="Somogy megye" alt="Somogy megye"></a></li>
                    <li class="county-logo"><a href="https://szabolcs.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/szabolcs-szatmar-bereg.png" title="Szabolcs-Szatmár-Bereg megye" alt="Szabolcs-Szatmár-Bereg megye"></a></li>
                    <li class="county-logo"><a href="https://tolna.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Tolna.png" title="Tolna megye" alt="Tolna megye"></a></li>
                    <li class="county-logo"><a href="https://vas.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Vas.png" title="Vas megye" alt="Vas megye"></a></li>
                    <li class="county-logo"><a href="https://veszprem.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Veszprem_igazgatosag_logo_kerek.png" title="Veszprém megye" alt="Veszprém megye"></a></li>
                    <li class="county-logo"><a href="https://zala.mlsz.hu" target="_blank"><img src="/design/igazgatosag/assets/img/cimer/Zala.png" title="Zala megye" alt="Zala megye"></a></li>
                </ul>
            </div>
        </div>
    </section>
    <section id="main-news" class="news">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 news-filters">
                    <ul>
                        <li><h2 class="main-title"><i class="icon-hirek"></i> Hírek</h2></li>
                        <li class="news-filter"><a href="javascript:hirvalto('h_valogatottak')" class="news-filter-a active" id="nfa-h_valogatottak">Válogatottak</a></li>
                        <li class="news-filter"><a href="javascript:hirvalto('h_bajnoksag-kupak')" class="news-filter-a " id="nfa-h_bajnoksag-kupak">Bajnokságok / Kupák</a></li>
                        <li class="news-filter"><a href="javascript:hirvalto('h_szovetseg')" class="news-filter-a " id="nfa-h_szovetseg">Szövetség</a></li>
                        <li class="news-filter"><a href="javascript:hirvalto('h_igazgatosagok')" class="news-filter-a " id="nfa-h_igazgatosagok">Megyei igazgatóságok</a></li>
                        <li class="news-filter"><a href="javascript:hirvalto('h_jatekvezetes')" class="news-filter-a " id="nfa-h_jatekvezetes">Játékvezetés</a></li>
                        <li class="filter-button hidden-md hidden-lg">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-filter" aria-hidden="true"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:hirvalto('h_valogatottak')">Válogatottak</a></li>
                                    <li><a href="javascript:hirvalto('h_bajnoksag-kupak')">Bajnokságok / Kupák</a></li>
                                    <li><a href="javascript:hirvalto('h_szovetseg')">Szövetség</a></li>
                                    <li><a href="javascript:hirvalto('h_igazgatosagok')">Megyei igazgatóságok</a></li>
                                    <li><a href="javascript:hirvalto('h_jatekvezetes')">Játékvezetés</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="hirblokk" id="h_valogatottak" >
                    <div class="col-md-12 col-xs-12 news-filter-title">
                        <h3>Válogatottak</h3>
                        <hr />
                    </div>
                    <div class="col-md-6 col-xs-12 normal-news">
                        <div class="thumbnail-big">
                            <div class="news-image">
                                <a href="https://valogatott.mlsz.hu/futsal-noi/hir/szurkolok/europa-elitje-csap-ossze-ukrajnaban" class="img-filter"></a>
                                <a href="https://valogatott.mlsz.hu/futsal-noi/hir/szurkolok/europa-elitje-csap-ossze-ukrajnaban">
                                    <img src="/adat/newse/24659/gyorskep/nagykep/dsc_8148.jpg" class="img-responsive" alt="Európa elitje csap össze Ukrajnában">
                                    <span class="dibl img-top-tags"><span class="vid-tag"><i class="icon-play"></i> Videó</span> <span class="vid-tag"><i class="icon-gallery"></i> Galéria</span></span>
                                    <span class="news-tag ferfi-bg ferfi-color">Futsal Női A</span>
                                </a>
                            </div>
                            <div class="caption style-text-dot">
                                <h3><a href="https://valogatott.mlsz.hu/futsal-noi/hir/szurkolok/europa-elitje-csap-ossze-ukrajnaban">Európa elitje csap össze Ukrajnában</a></h3>
                                <p>Az UEFA-ranglista top 10 női futsalválogatottja közül öt vesz részt a lvivi kupán. Első ellenfelünk a negyedik helyezett ukrán együttes lesz vasárnap; az ukránok ellen a saját, támadó játékunkkal készülünk.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/hir/csapat/marco-rossi-ujra-szamit-hangya-szilveszterre" class="img-filter"></a>
                                        <a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/hir/csapat/marco-rossi-ujra-szamit-hangya-szilveszterre">
                                            <img src="/adat/newse/24642/gyorskep/nagykep/hangyarossi.jpg" class="img-responsive" alt="Marco Rossi újra számít Hangya Szilveszterre">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Férfi A-válogatott</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/hir/csapat/marco-rossi-ujra-szamit-hangya-szilveszterre">Marco Rossi újra számít Hangya Szilveszterre</a></h4>
                                        <p>Marco Rossi a napokban az OTP Bank Liga Spanyolországban edzőtáborozó csapatainál tesz látogatást. Elsőként a Mol Fehérvár FC-t látogatta meg a szövetségi kapitány, aki arra is kihasználta az adódó lehetőséget, hogy Hangya Szilveszterrel tisztázzon egy korábbi félreértést.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://valogatott.mlsz.hu/futsal-ferfi-utanpotlas/hir/szurkolok/ket-gyozelem-ket-vereseg-porecben" class="img-filter"></a>
                                        <a href="https://valogatott.mlsz.hu/futsal-ferfi-utanpotlas/hir/szurkolok/ket-gyozelem-ket-vereseg-porecben">
                                            <img src="/adat/newse/24620/gyorskep/nagykep/futsalu17.jpg" class="img-responsive" alt="Két győzelem, két vereség Porecben">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Futsal Férfi utánpótlás</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://valogatott.mlsz.hu/futsal-ferfi-utanpotlas/hir/szurkolok/ket-gyozelem-ket-vereseg-porecben">Két győzelem, két vereség Porecben</a></h4>
                                        <p>Férfi U19-es futsalválogatottunk szombattól keddig egy ötcsapatos nemzetközi tornán vett részt a horvátországi Porecben.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Futsal Női A</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://valogatott.mlsz.hu/futsal-noi/hir/szurkolok/ukrajnaban-kezdi-az-evet-a-noi-futsalvalogatott">Ukrajnában kezdi az évet a női futsalválogatott</a></h4>
                                        <p>Hatcsapatos tornával indítja az évet Dombó János szövetségi edző csapata Lvovban. Az Eb-negyedik ukránokkal és a finnekkel kezdjük a tornát, majd egy helyosztót is játszunk január 12. és 15. között.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Férfi A-válogatott</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://valogatott.mlsz.hu/ferfi-a-valogatott/hir/csapat/a-valogatott-2019-bravurok-es-csalodasok">A-válogatott 2019: Bravúrok és csalódások, még élnek az Eb-remények</a></h4>
                                        <p>2019-ben a magyar férfi labdarúgó-válogatott Marco Rossi szövetségi kapitány vezetésével tíz hivatalos, nemzetek közötti mérkőzést játszott, közülük nyolc tétmérkőzést és két felkészülési meccset. Az év első felében jól teljesítettünk az Eb-selejtező sorozatban, végül azonban nem értük el a célunkat, a csoport első két helyének valamelyikét.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><a href="http://valogatott.mlsz.hu" class="box-btn box-btn-big">Több hír a válogatottakról <i class="icon-right" aria-hidden="true"></i></a></div>
                </div>
                <div class="hirblokk" id="h_bajnoksag-kupak" style="display: none;">
                    <div class="col-md-12 col-xs-12 news-filter-title">
                        <h3>Bajnokságok / Kupák</h3>
                        <hr />
                    </div>
                    <div class="col-md-6 col-xs-12 normal-news">
                        <div class="thumbnail-big">
                            <div class="news-image">
                                <a href="https://www.mlsz.hu/hir/noi-teremlabdarugo-kupa-az-mtk-es-az-astra-volt-a-szombati-legjobb" class="img-filter"></a>
                                <a href="https://www.mlsz.hu/hir/noi-teremlabdarugo-kupa-az-mtk-es-az-astra-volt-a-szombati-legjobb">
                                    <img src="/adat/newse/24658/gyorskep/nagykep/20200111smic2946.jpg" class="img-responsive" alt="Női teremlabdarúgó-kupa: az MTK és az Astra is verhetetlen volt szombaton">
                                    <span class="dibl img-top-tags"> </span>
                                    <span class="news-tag ferfi-bg ferfi-color">Bajnokságok / Kupák</span>
                                </a>
                            </div>
                            <div class="caption style-text-dot">
                                <h3><a href="https://www.mlsz.hu/hir/noi-teremlabdarugo-kupa-az-mtk-es-az-astra-volt-a-szombati-legjobb">Női teremlabdarúgó-kupa: az MTK és az Astra is verhetetlen volt szombaton</a></h3>
                                <p>Két csapat is hibátlan mérleggel zárta a Szigetszentmiklóson zajló női NB I-es teremlabdarúgó-kupa első játéknapját.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://www.mlsz.hu/hir/teremtornaval-indul-a-teli-szezon-a-noi-elvonal-csapatainak" class="img-filter"></a>
                                        <a href="https://www.mlsz.hu/hir/teremtornaval-indul-a-teli-szezon-a-noi-elvonal-csapatainak">
                                            <img src="/adat/newse/24623/gyorskep/nagykep/terem.jpg" class="img-responsive" alt="Teremtornával indul a téli szezon a női élvonal csapatainak">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Bajnokságok / Kupák</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://www.mlsz.hu/hir/teremtornaval-indul-a-teli-szezon-a-noi-elvonal-csapatainak">Teremtornával indul a téli szezon a női élvonal csapatainak</a></h4>
                                        <p>A Szigetszentmiklósi Városi Sportcsarnok fogadja a női labdarúgókat – idén negyedik alkalommal rendezi meg az MLSZ a téli Teremlabdarúgó-kupát. A Jet-Sol Liga csapatai, illetve a másodosztályban éllovas MLE együttese január 11-12-én mérkőznek meg egymással. A döntő és a bronzmeccs az M4 Sporton is követhető lesz.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://www.mlsz.hu/hir/futsal-orult-meccs-budaorson-fradi-siker-az-evzaron" class="img-filter"></a>
                                        <a href="https://www.mlsz.hu/hir/futsal-orult-meccs-budaorson-fradi-siker-az-evzaron">
                                            <img src="/adat/newse/24567/gyorskep/nagykep/fradifutsal.jpg" class="img-responsive" alt="Futsal: Őrült meccs Budaörsön, Fradi-siker az évzárón">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Bajnokságok / Kupák</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://www.mlsz.hu/hir/futsal-orult-meccs-budaorson-fradi-siker-az-evzaron">Futsal: Őrült meccs Budaörsön, Fradi-siker az évzárón</a></h4>
                                        <p>A férfi futsal NB I-ben a 2019-es év utolsó bajnoki mérkőzéseit. Tizennégy forduló után a címvédő MVFC Berettyóújfalu hat pont előnnyel vezeti a tabellát a Haladás előtt.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Bajnokságok / Kupák</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://www.mlsz.hu/hir/az-el-szereples-mellett-javitott-nb-i-es-teljesitmenyen-a-fradi">Az El-szereplés mellett javított NB I-es őszi teljesítményén a Fradi</a></h4>
                                        <p>A Paks először győzött egy megnyert mérkőzés után az OTP Bank Liga 2019–2020-as idényében. A MOL Fehérvár veretlenül zárta 2019 őszi idegenbeli bajnoki mérkőzései sorát, vendégként még a Ferencvárosnál is egy ponttal többet szerzett. A Ferencváros utolsó három őszi bajnoki gólját kivétel nélkül Olekszandr Zubkov lőtte. Érdekességek az NB I utolsó 2019-es fordulója után.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Bajnokságok / Kupák</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://www.mlsz.hu/hir/ferencvarosi-gyozelemmel-zarult-az-ev">Ferencvárosi győzelemmel zárult az év</a></h4>
                                        <p>A Ferencváros 1-0-ra legyőzte a DVTK-t Miskolcon, így négy pont előnnyel telel az OTP Bank Liga tabellájának élén. A bajnokság idei utolsó mérkőzésén - a két csapat 100. egymás elleni élvonalbeli összecsapásán - egy szabadrúgásgól döntött.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><a href="/hirek/bajnoksag-kupak" class="box-btn box-btn-big">Több hír a bajnokságról <i class="icon-right" aria-hidden="true"></i></a></div>
                </div>
                <div class="hirblokk" id="h_szovetseg" style="display: none;">
                    <div class="col-md-12 col-xs-12 news-filter-title">
                        <h3>Szövetség</h3>
                        <hr />
                    </div>
                    <div class="col-md-6 col-xs-12 normal-news">
                        <div class="thumbnail-big">
                            <div class="news-image">
                                <a href="https://szovetseg.mlsz.hu/hir/eb-keszulodes-2019-ben" class="img-filter"></a>
                                <a href="https://szovetseg.mlsz.hu/hir/eb-keszulodes-2019-ben">
                                    <img src="/adat/newse/24380/gyorskep/nagykep/75147256_3476831219008654_7385283062466084864_o.jpg" class="img-responsive" alt="Eb-készülődés 2019-ben">
                                    <span class="dibl img-top-tags"> </span>
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Szövetség</span>
                                </a>
                            </div>
                            <div class="caption style-text-dot">
                                <h3><a href="https://szovetseg.mlsz.hu/hir/eb-keszulodes-2019-ben">Eb-készülődés 2019-ben</a></h3>
                                <p>2019-ben megnyitott a Puskás Aréna, a 2020-as Eb-t rendező 12 európai stadion egyike; Gera Zoltán lett a magyarországi nagykövet; a közönség kiválasztotta a hazánkat képviselő freestylereket, és az UEFA Budapestről indította el a torna jegyeinek értékesítését.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://szovetseg.mlsz.hu/hir/az-ev-sportoloja-kihirdettek-2019-dobogosait" class="img-filter"></a>
                                        <a href="https://szovetseg.mlsz.hu/hir/az-ev-sportoloja-kihirdettek-2019-dobogosait">
                                            <img src="/adat/newse/24604/gyorskep/nagykep/gala.jpg" class="img-responsive" alt="Az Év Sportolója – kihirdették 2019 dobogósait">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">MLSZ Szövetség</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szovetseg.mlsz.hu/hir/az-ev-sportoloja-kihirdettek-2019-dobogosait">Az Év Sportolója – kihirdették 2019 dobogósait</a></h4>
                                        <p>A Magyar Sportújságírók Szövetsége (MSÚSZ) által kiírt szavazáson 62. alkalommal választják meg az újságírók az év sportolóit. A legszebb gólról most is a szurkolók döntenek. Az elismeréseket a Nemzeti Színházban, január 16-án adják át az M4 Sport élő közvetítése mellett.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://szovetseg.mlsz.hu/hir/2019-legjobbjaira-szavaznak-a-sportujsagirok" class="img-filter"></a>
                                        <a href="https://szovetseg.mlsz.hu/hir/2019-legjobbjaira-szavaznak-a-sportujsagirok">
                                            <img src="/adat/newse/24596/gyorskep/nagykep/62.jpg" class="img-responsive" alt="2019 legjobbjaira szavaznak a sportújságírók">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">MLSZ Szövetség</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szovetseg.mlsz.hu/hir/2019-legjobbjaira-szavaznak-a-sportujsagirok">2019 legjobbjaira szavaznak a sportújságírók</a></h4>
                                        <p>Megkezdődött az internetes szavazás 2019 legjobb sportolóira. Az MSÚSZ-tagok 62. alkalommal voksolhatnak, idén is külön kategóriában lehet szavazni az év női és férfi labdarúgójára.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Szövetség</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szovetseg.mlsz.hu/hir/ma-lenne-75-eves-varga-zoltan">Ma lenne 75 éves Varga Zoltán</a></h4>
                                        <p>Hetvenöt éve született Varga Zoltán, aki 1964 és 1968 között 12 mérkőzésen két gólt szerzett a válogatottban. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Szövetség</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szovetseg.mlsz.hu/hir/tiz-eve-drukkolt-az-orszag-az-egyiptomi-hosoknek">Tíz éve drukkolt az ország az egyiptomi hősöknek</a></h4>
                                        <p>Egervári Sándor, az U20-as csapat akkori vezetőedzője és Sisa Tibor, ugyanezen generáció korábbi mestere emlékezett a csapat menetelésére; a játékosok nevében Németh Krisztián köszönte meg az edzői segítséget a tél szünetben tartott ünnepségen. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><a href="https://szovetseg.mlsz.hu" class="box-btn box-btn-big">Több hír a szövetségről <i class="icon-right" aria-hidden="true"></i></a></div>
                </div>
                <div class="hirblokk" id="h_igazgatosagok" style="display: none;">
                    <div class="col-md-12 col-xs-12 news-filter-title">
                        <h3>Megyei igazgatóságok</h3>
                        <hr />
                    </div>
                    <div class="col-md-6 col-xs-12 normal-news">
                        <div class="thumbnail-big">
                            <div class="news-image">
                                <a href="https://szabolcs.mlsz.hu/hir/elindult-a-jatekvezetoi-tanfolyam" class="img-filter"></a>
                                <a href="https://szabolcs.mlsz.hu/hir/elindult-a-jatekvezetoi-tanfolyam">
                                    <img src="/adat/newse/24657/gyorskep/nagykep/jv_tanfolyam2020.jpg" class="img-responsive" alt="Elindult a játékvezetői tanfolyam">
                                    <span class="dibl img-top-tags"> </span>
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Szabolcs-Szatmár-Bereg Megyei Igazgatóság</span>
                                </a>
                            </div>
                            <div class="caption style-text-dot">
                                <h3><a href="https://szabolcs.mlsz.hu/hir/elindult-a-jatekvezetoi-tanfolyam">Elindult a játékvezetői tanfolyam</a></h3>
                                <p>Csütörtök délután a nyíregyházi Continental Aréna első emeleti konferenciatermében vette kezdetét az MLSZ Szabolcs-Szatmár-Bereg megyei igazgatóság játékvezetői bizottsága által meghirdetett, 2020. évi alapfokú játékvezetői tanfolyam.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://szabolcs.mlsz.hu/hir/gratulalunk-fiuk" class="img-filter"></a>
                                        <a href="https://szabolcs.mlsz.hu/hir/gratulalunk-fiuk">
                                            <img src="/adat/newse/24656/gyorskep/nagykep/megyevalogatott_2020jan.jpg" class="img-responsive" alt="Gratulálunk fiúk!">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">MLSZ Szabolcs-Szatmár-Bereg Megyei Igazgatóság</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szabolcs.mlsz.hu/hir/gratulalunk-fiuk">Gratulálunk fiúk!</a></h4>
                                        <p>Tegnap este ünnepélyes vacsorával, valamint egy kis ajándékkal köszönte meg a Szabolcs-Szatmár-Bereg megyei Igazgatóság a mezőkövesdi MAVONT tornán résztvevő megyei amatőr válogatott játékosainak és a szakmai stábtagoknak a decemberi régiós tornán nyújtott kimagasló teljesítményüket.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://szabolcs.mlsz.hu/hir/nicoflex-adomany-a-megyei-csapatoknak" class="img-filter"></a>
                                        <a href="https://szabolcs.mlsz.hu/hir/nicoflex-adomany-a-megyei-csapatoknak">
                                            <img src="/adat/newse/24655/gyorskep/nagykep/nicoflex_adomany.jpg" class="img-responsive" alt="Nicoflex adomány a megyei csapatoknak">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">MLSZ Szabolcs-Szatmár-Bereg Megyei Igazgatóság</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szabolcs.mlsz.hu/hir/nicoflex-adomany-a-megyei-csapatoknak">Nicoflex adomány a megyei csapatoknak</a></h4>
                                        <p>Ezúton tájékoztatjuk a Szabolcs-Szatmár-Bereg megyei labdarúgó egyesületek képviselőit, hogy egy magyarországi cég az MLSZ-en keresztül Nicoflex kenőcsöket ajánlott fel térítésmentesen az amatőr sportegyesületek részére. A Megyei Igazgatóságunk is kapott ebből egy komolyabb mennyiséget, mely az Igazgatóságunk irodájában van elhelyezve.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Szabolcs-Szatmár-Bereg Megyei Igazgatóság</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://szabolcs.mlsz.hu/hir/grassroots-c-tanfolyam-indul-debrecenben">Grassroots C tanfolyam indul Debrecenben</a></h4>
                                        <p>A Magyar Labdarúgó Szövetség Felnőttképzési Intézete - a 2013. évi LXXVII. törvény hatálya alá nem tartozó iskolarendszeren kívül szervezett MLSZ Grassroots C edzői tanfolyamokat indít 2020. tavaszán az országban több helyszínen. Megyénkhez legközelebb Debrecenben lesz ilyen képzés.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">MLSZ Budapesti Igazgatóság</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://budapest.mlsz.hu/hir/blsz-teli-teremtorna-kozepdonto">BLSZ Téli Teremtorna - Középdöntő és döntő</a></h4>
                                        <p>A BLSZ téli felnőtt teremtorna eredményei:</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><a href="https://igazgatosagok.mlsz.hu" class="box-btn box-btn-big">Több hír az igazgatóságokról <i class="icon-right" aria-hidden="true"></i></a></div>
                </div>
                <div class="hirblokk" id="h_jatekvezetes" style="display: none;">
                    <div class="col-md-12 col-xs-12 news-filter-title">
                        <h3>Játékvezetés</h3>
                        <hr />
                    </div>
                    <div class="col-md-6 col-xs-12 normal-news">
                        <div class="thumbnail-big">
                            <div class="news-image">
                                <a href="https://budapest.mlsz.hu/hir/bacs-kiskun-megye-nyerte-a-xv.-sipmester-fesztivalt" class="img-filter"></a>
                                <a href="https://budapest.mlsz.hu/hir/bacs-kiskun-megye-nyerte-a-xv.-sipmester-fesztivalt">
                                    <img src="/adat/newse/24600/gyorskep/nagykep/tz_5090.jpg" class="img-responsive" alt="Bács-Kiskun megye nyerte a XV. Sípmester Fesztivált">
                                    <span class="dibl img-top-tags"> </span>
                                    <span class="news-tag ferfi-bg ferfi-color">Hírek</span>
                                </a>
                            </div>
                            <div class="caption style-text-dot">
                                <h3><a href="https://budapest.mlsz.hu/hir/bacs-kiskun-megye-nyerte-a-xv.-sipmester-fesztivalt">Bács-Kiskun megye nyerte a XV. Sípmester Fesztivált</a></h3>
                                <p>Az MLSZ Budapesti Igazgatóság és annak Játékvezető Bizottságának szervezésében 2020. január 4-én és 5-én  került sor a XV. Sípmester Fesztiválra.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://jatekvezetes.mlsz.hu/hir/uj-kihivasokra-koncentral-a-jatekvezetokent-visszavonulo-kassai-viktor" class="img-filter"></a>
                                        <a href="https://jatekvezetes.mlsz.hu/hir/uj-kihivasokra-koncentral-a-jatekvezetokent-visszavonulo-kassai-viktor">
                                            <img src="/adat/newse/24591/gyorskep/nagykep/kassai1.jpg" class="img-responsive" alt="Új kihívásokra koncentrál a játékvezetőként visszavonuló Kassai Viktor">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Általános</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://jatekvezetes.mlsz.hu/hir/uj-kihivasokra-koncentral-a-jatekvezetokent-visszavonulo-kassai-viktor">Új kihívásokra koncentrál a játékvezetőként visszavonuló Kassai Viktor</a></h4>
                                        <p>Az elmúlt két évtized legsikeresebb magyar játékvezetőjét nem látjuk többé a hazai és külföldi futballpályákon. Közel harmincéves pályafutása alatt megszerzett tapasztalatát más területen hasznosítja a jövőben.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-side-news">
                                <div class="thumbnail-big">
                                    <div class="news-image">
                                        <a href="https://jatekvezetes.mlsz.hu/hir/a-bl-ben-is-szamitanak-jatekvezetoinkre" class="img-filter"></a>
                                        <a href="https://jatekvezetes.mlsz.hu/hir/a-bl-ben-is-szamitanak-jatekvezetoinkre">
                                            <img src="/adat/newse/24037/gyorskep/nagykep/kulcs.jpg" class="img-responsive" alt="A BL-ben is számítanak játékvezetőinkre">
                                            <span class="dibl img-top-tags"> </span>
                                            <span class="news-tag ferfi-bg ferfi-color">Általános</span>
                                        </a>
                                    </div>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://jatekvezetes.mlsz.hu/hir/a-bl-ben-is-szamitanak-jatekvezetoinkre">A BL-ben is számítanak játékvezetőinkre</a></h4>
                                        <p>Nemzetközi tornákon kapnak szerepet októberben a magyar játékvezetők és asszisztensek.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Általános</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://jatekvezetes.mlsz.hu/hir/magyar-jatekvezetok-a-nemzetkozi-kupakban">Magyar játékvezetők a nemzetközi kupákban</a></h4>
                                        <p>Több játékvezetőnk is nemzetközi mérkőzésen működik közre a napokban.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 normal-news normal-noimg-news">
                                <div class="thumbnail-big">
                                    <span class="news-tag ferfi-bg ferfi-color">Általános</span>
                                    <span class="dibl no-img-tags no-img-kozpont-tags"> </span>
                                    <div class="caption style-text-dot">
                                        <h4><a href="https://jatekvezetes.mlsz.hu/hir/vb-negyeddontoben-kap-szerepet-kulcsar-katalin">Vb-negyeddöntőben kap szerepet Kulcsár Katalin</a></h4>
                                        <p>Negyedik mérkőzésén számítanak a magyar játékvezetőre a franciaországi női világbajnokságon.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"><a href="https://jatekvezetes.mlsz.hu" class="box-btn box-btn-big">Több hír a játékvezetésről <i class="icon-right" aria-hidden="true"></i></a></div>
                </div>

            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.general', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>