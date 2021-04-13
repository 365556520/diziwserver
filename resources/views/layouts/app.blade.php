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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
{{--
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    @yield('css')
</head>
<body>
    <div id="app">


{{--


        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top container  ">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img  src="{{ asset('myimages/images/logo.png')  }}" height="45px">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="{{ url('/') }}">首页 <span class="sr-only">(current)</span></a>
                    <a class="nav-link" href="#">游戏</a>
                    <a class="nav-link" href="#">作品</a>

                </div>
            </div>
        </nav>
--}}
{{--
                                    <!-- Right Side Of Navbar -->
                                    <ul class="navbar-nav">
                                        <!-- Authentication Links -->
                                        @guest
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a>
                                            </li>
                                            @if (Route::has('register'))
                                          --}}{{----}}{{--      <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('register') }}">{{ __('注册') }}</a>
                                                </li>--}}{{----}}{{--
                                            @endif
                                        @else
                                            <li class="nav-item dropdown">
                                                <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{ Auth::user()->name }} <span class="caret"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        @endguest
                                    </ul>--}}

    <main class="py-4">
        @yield('content')
    </main>

    </div>
    @yield('js')
</body>
</html>
