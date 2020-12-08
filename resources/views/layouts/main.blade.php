<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>@yield('title') - {{ config('app.name', 'Лига') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css').'?v='.config('app.version') }}" rel="stylesheet">

    <link href="{{ asset('fonts/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{{ asset('css/custom.css').'?v='.config('app.version') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    @yield('css')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/nprogress.js') }}"></script>
    @if(session('info') || session('error'))
<script src="{{ asset('js/notify/pnotify.core.js') }}"></script>
    <script src="{{ asset('js/notify/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/notify/pnotify.nonblock.js') }}"></script>
    @endif
    @yield('js')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="nav-md">
<div id="app">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-futbol-o"></i> <span>На сайт</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{ asset('/images/no_photo.jpg') }}" alt="{{ Auth::user()->name }}" class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Здравствуйте,</span>
                        <h2>{{ Auth::user()->name }}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>Меню</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> Панель управления <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ route('home') }}">Главная</a></li>
                                    <li><a href="{{ route('profile', [ 'id' => Auth::user()->id ]) }}">Анкета</a></li>
                                    @if (Auth::user()->isAdmin()) <li><a href="{{ route('register') }}">Регистрация</a></li><li><a href="{{ route('users') }}">Пользователи</a></li> @endif
                                    <li><a style="cursor: pointer;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-edit"></i> Содержимое <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ route('admin_news') }}">Новости</a></li>
                                    <li><a href="empty.html">Голосования</a></li>
                                    <li><a href="empty.html">Страницы</a></li>
                                    <li><a href="empty.html">Трансляции</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Соревнования</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-trophy"></i> Турниры <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="empty.html">Чемпионаты и Кубки</a></li>
                                    <li><a href="{{ url('/home/tournlist') }}">Перечень соревнований</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-sticky-note"></i> Реестр <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="empty.html">Команды</a></li>
                                    <li><a href="{{ route('admin_person') }}">Участники</a></li>
                                    <li><a href="empty.html">Стадионы</a></li>
                                    <li><a href="empty.html">Администрация команды</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Моя анкета" href="{{ route('profile', [ 'id' => Auth::user()->id ]) }}">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Во весь экран" onclick="fullScreen(document.documentElement)">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Выйти из Панели управления" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->
        <div class="right_col" role="main">
            @if (session('info'))
                <script type="text/javascript">
                    var permanotice, tooltip, _alert;
                    $(function() {
                        new PNotify({
                            title: 'Сообщение',
                            text: '{{ session('info') }}',
                            type: 'success'
                        });

                    });
                </script>
            @endif
            @if (session('error'))
                <script type="text/javascript">
                    var permanotice, tooltip, _alert;
                    $(function() {
                        new PNotify({
                            title: 'Ошибка',
                            text: '{{ session('error') }}',
                            type: 'error'
                        });

                    });
                </script>
            @endif
            @yield('content')

            <!-- footer content -->
            <footer>
                <div class="copyright-info">
                    <p class="pull-right">Система управления соревнованиями
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
</div>
@yield('js_footer')
<script src="{{ asset('js/custom.js?fvd331c') }}"></script>
<script>
    NProgress.done();
</script>
<!-- /datepicker -->
<!-- /footer content -->
</body>

</html>
