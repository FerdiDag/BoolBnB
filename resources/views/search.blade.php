{{-- @extends('layouts.dashboard_search')

@section('content')
  <main>
      <div class="container">
        <div class="row">
          <div class="input-group mb-3 search-bar">
            <input id="search" type="search" class="form-control input-search" placeholder="Dove vuoi andare?" aria-describedby="basic-addon2">
            <div class="input-group-append button-box">
            <button class="btn btn-outline-secondary" id="search-button" type="button">
            <i class="fas fa-search"></i>
              Cerca
            </button>
            </div>
          </div>
          <div class="w-100 d-flex justify-content-around">
            <div class="form-group">
              <label for="number_of_rooms"></label>
              <select class="form-control" id="number_of_rooms" >
                <option value="">Stanze</option>
                @for ($i=1; $i < 31; $i++)
                  <option>{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <label for="number_of_beds"></label>
              <select class="form-control" id="number_of_beds">
                <option value="">Letti</option>
                @for ($i=1; $i < 31; $i++)
                  <option>{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <label for="number_of_bathrooms"></label>
              <select class="form-control" id="number_of_bathrooms">
                <option value="">Km</option>
                <option value="">5 Km</option>
                <option value="">10 Km</option>
                <option value="">15 Km</option>
                <option value="">20 Km</option>
              </select>
            </div>
          </div>
          <div id="services" class="form-group w-100 filter-search">
              Servizi :
              @foreach ($services as $service)
                  <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                          class="form-check-input" name="services[]" type="checkbox" value="{{$service->id}}">
                          {{$service->type}}
                      </label>
                  </div>
              @endforeach
              @error('services')
                  <small class="d-block text-danger">{{ $message }}</small>
              @enderror
          </div>
        </div>
      </div>
      <section class="in-evidenza">
        <div class="container">
          <div class="row">
            <div class="text-center w-100">
              <h1 >In Evidenza :</h1>
            </div>
            <div class="d-flex justify-content-around box-in-evidenza">

            </div>
          </div>
        </div>
      </section>
  </main>
@endsection --}}

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
    <aside class="float-md-left" id="advanced-search">
        <nav id="aside-nav" >
            <ul>
              <li>
                <div class="input-group mb-3 search-filter-bar">
                  <input id="search" type="search" class="form-control input-search" placeholder="Ricerca avanzata" aria-describedby="basic-addon2">
                  <div class="input-group-append button-box">
                  <button class="btn btn-outline-secondary" id="search-filter-button" type="button">
                  <i class="fas fa-search"></i>
                  </button>
                  </div>
                </div>
              </li>
              <li class="">
                <div class="w-100 d-flex flex-column justify-content-around">
                  <div class="form-group">
                    <label for="number_of_rooms"></label>
                    <select class="form-control" id="number_of_rooms" >
                      <option value="">Stanze</option>
                      @for ($i=1; $i < 31; $i++)
                        <option>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="number_of_beds"></label>
                    <select class="form-control" id="number_of_beds">
                      <option value="">Letti</option>
                      @for ($i=1; $i < 31; $i++)
                        <option>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="number_of_bathrooms"></label>
                    <select class="form-control" id="number_of_bathrooms">
                      <option value="">Km</option>
                      <option value="">5 Km</option>
                      <option value="">10 Km</option>
                      <option value="">15 Km</option>
                      <option value="">20 Km</option>
                    </select>
                  </div>
                </div>
              </li>
              <li>
                <div id="services" class="form-group d-flex flex-column w-100 filter-search">
                    @foreach ($services as $service)
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                class="form-check-input" name="services[]" type="checkbox" value="{{$service->id}}">
                                {{$service->type}}
                            </label>
                        </div>
                    @endforeach
                    @error('services')
                        <small class="d-block text-danger">{{ $message }}</small>
                    @enderror
                </div>
              </li>
            </ul>
        </nav>
    </aside>
    <main class="float-left">
        @yield('content')
    </main>
</body>

</html>
