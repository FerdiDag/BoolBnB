<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset("img/icona.png")}}">
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.37.2/maps/maps.css' />
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/5.x/5.37.2/maps/maps-web.min.js'></script>
    <script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>
</head>

<body id="bk-office" class="clearfix">
    <header class="float-left">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div id="header-left">
                <div class="logo-container">
                    <a href="{{route("home")}}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid">
                    </a>
                </div>
            </div>
            <div id="header-right" class="d-flex justify-content-end align-items-center">
                <nav id="main-nav">
                    <ul class="list-inline d-flex justify-content-end align-items-center">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                <span class="d-none d-md-inline">
                                    Home utenti
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="d-none d-md-inline">
                                    Logout
                                </span>
                            </a>
                        </li>
                        <li id="aside-toggle" class="d-md-none">
                            <i class="fas fa-bars"></i>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </nav>
            </div>
        </div>
    </header>
    <aside class="float-md-left">
        <nav id="aside-nav">
            <ul>
                <li class="{{ Request::route()->getName() == 'admin.home' ? 'active' : '' }}">
                    <a href="{{route('admin.home')}}">
                        <i class="fas fa-home"></i>
                        Home admin
                    </a>
                </li>
                <li class="{{ Request::route()->getName() == 'admin.apartments.create' ? 'active' : '' }}">
                    <a href="{{route("admin.apartments.create")}}">
                        <i class="fas fa-plus"></i>
                        Aggiungi appartamento
                    </a>
                </li>
                @if (!Auth::user()->apartments->isEmpty())
                    <li class="{{ Request::route()->getName() == 'admin.apartments.index' ? 'active' : '' }}">
                        <a href="{{route('admin.apartments.index')}}">
                            <i class="fas fa-sliders-h"></i>
                            Gestisci appartamenti
                        </a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'admin.index_message' ? 'active' : '' }}">
                        <a href="{{route("admin.index_message")}}">
                            <i class="fas fa-envelope-open-text"></i>
                            Messaggi
                        </a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'admin.index_stats' ? 'active' : '' }}">
                        <a href="{{route("admin.index_stats")}}">
                            <i class="fas fa-chart-line"></i>
                            Statistiche
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </aside>
    <main class="float-left">
        @yield('content')
    </main>
</body>

</html>
