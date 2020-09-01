<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('page-title')</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body id="bk-office" class="clearfix">
        <header class="float-left">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div id="header-left">
                    <div class="logo-container">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid">
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
                                <a href="{{ route('logout') }}" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
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
                        <li>
                            <a href="#">
                                <i class="fas fa-home"></i>
                                Home admin
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-plus"></i>
                                Aggiungi appartamento
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-sliders-h"></i>
                                Gestisci appartamenti
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-envelope-open-text"></i>
                                Messaggi
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-chart-line"></i>
                                Statistiche
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-angle-double-up"></i>
                                Sponsorizza
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
        <main class="float-left">
            @yield('content')
        </main>
    </body>
</html>
