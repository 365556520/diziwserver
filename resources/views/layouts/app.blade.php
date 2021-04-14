<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
{{--
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>--}}

<!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;600&display=swap" rel="stylesheet">
{{--
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

<!-- Template CSS 模板 -->
    <link href="{{ asset('mycss/qiantai/assets/css/style-starter.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body>
<!-- header -->
        <header id="site-header" class="fixed-top">
            <div class="container">
                <nav class="navbar navbar-expand-lg stroke">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class="fa fa-laptop"></span> diziw
                    </a>
                    <!-- if logo is image enable this
                <a class="navbar-brand" href="#index.html">
                    <img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
                </a> -->
                    <button class="navbar-toggler  collapsed bg-gradient" type="button" data-toggle="collapse"
                            data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
                        <span class="navbar-toggler-icon fa icon-close fa-times"></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ url('/') }}">首页<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item @@about__active">
                                <a class="nav-link" href="about.html">关于我</a>
                            </li>
                            <li class="nav-item @@contact__active">
                                <a class="nav-link" href="contact.html">笔记</a>
                            </li>
                            <li class="nav-item @@contact__active">
                                <a class="nav-link" href="contact.html">我的游戏</a>
                            </li>
                        </ul>
                    </div>
                    <!-- toggle switch for light and dark theme -->
                    <div class="mobile-position">
                        <nav class="navigation">
                            <div class="theme-switch-wrapper">
                                <label class="theme-switch" for="checkbox">
                                    <input type="checkbox" id="checkbox">
                                    <div class="mode-container">
                                        <i class="gg-sun"></i>
                                        <i class="gg-moon"></i>
                                    </div>
                                </label>
                            </div>
                        </nav>
                    </div>
                    <!-- //toggle switch for light and dark theme -->
                </nav>
            </div>
        </header>
        <!-- //header -->


        @yield('content')

    <!--/MENU-JS-->
    <script>
        $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();

            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });

        //Main navigation Active Class Add Remove
        $(".navbar-toggler").on("click", function () {
            $("header").toggleClass("active");
        });
        $(document).on("ready", function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
            $(window).on("resize", function () {
                if ($(window).width() > 991) {
                    $("header").removeClass("active");
                }
            });
        });
    </script>
    <!--//MENU-JS-->

    @yield('js')
    <!-- bootstrap js -->
    <script src="{{ asset('mycss/qiantai/assets/js/bootstrap.min.js')}}"></script>
</body>
</html>
