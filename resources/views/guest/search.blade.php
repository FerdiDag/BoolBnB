@extends('layouts.app')
@section("page-title","La tua ricerca")

@section('content')
  <main>
      <div id="index" class="container">
        <div class="row">
          <div class="box-advanced-search">
            <div class="input-group mb-3 search-bar">
              <input id="search" type="search" class="form-control input-search" placeholder="Dove vuoi andare?" aria-describedby="basic-addon2" value={{isset($address) ? $address : ''}}>
              <div class="input-group-append button-box">
              <button class="btn btn-outline-secondary" id="search-button" type="button">
              <i class="fas fa-search"></i>
                Cerca
              </button>
              </div>
            </div>
              <div id="services" class="form-group w-80 filter-search">
                <div class="number-services-box">
                  @foreach ($services as $service)
                      <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                              class="form-check-input" id="services-advanced-search" name="services[]" type="checkbox" value="{{$service->id}}">
                              {{$service->type}}
                          </label>
                      </div>
                  @endforeach
                  @error('services')
                      <small class="d-block text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            <div class="number-box-filters">
              <div class="form-group select-option">
                <label for="number_of_rooms">Numero di stanze :</label>
                <select class="form-control" id="number_of_rooms" >
                  <option value="">1</option>
                  @for ($i=2; $i < 31; $i++)
                    <option>{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group select-option">
                <label for="number_of_beds">Numero di letti :</label>
                <select class="form-control" id="number_of_beds">
                  <option value="">1</option>
                  @for ($i=2; $i < 31; $i++)
                    <option>{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group select-option">
                <label for="Km">Km :</label>
                <select class="form-control" id="km">
                  <option value="">20 Km</option>
                  @for ($i=30; $i <= 70; $i=$i + 10)
                    <option value="">{{$i}} Km</option>
                  @endfor
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section class="appartamenti">
        <div class="container">
              @if (isset($apartments) && isset($sponsorships))
                  @php
                      $apartments_in_page = [];
                  @endphp
                  <div class="marked">
                      @foreach ($sponsorships as $sponsorship)
                          @php
                              array_push($apartments_in_page, $sponsorship->apartment->id);
                          @endphp

                          <a href="{{route("show", ["slug" => $sponsorship->apartment->slug])}}" class="col-12 box d-block mt-3 mb-3" data-id={{$sponsorship->apartment->id}}>
                              <div class="row">
                                  <div class="img-container col-12 col-md-5">
                                          @if (!$sponsorship->apartment->cover_image)
                                          <img src="{{asset('img/immagine-non-disponibile.gif')}}" alt="">
                                          @else
                                          <img src="{{ asset('storage/' . $sponsorship->apartment->cover_image) }}">
                                          @endif
                                  </div>
                                  <div class="text-container d-flex col-12 col-md-7 flex-column justify-content-between">
                                      <div class="title">
                                          <h2>{{$sponsorship->apartment->description_title}}</h2>
                                          <p class="font-weight-lighter">{{$sponsorship->apartment->description}}</p>
                                      </div>
                                      <div class="features">
                                          <ul>
                                              <li class="d-none d-md-block">Numero di letti: <span>{{$sponsorship->apartment->number_of_beds}}</span></li>
                                              <li class="d-none d-md-block">Numero di stanze: <span>{{$sponsorship->apartment->number_of_rooms}}</span></li>
                                              <li class="d-none d-md-block">Numero di bagni:  <span>{{$sponsorship->apartment->number_of_bathrooms}}</span></li>
                                              <li class="d-none d-md-block">Grandezza: <span>{{$sponsorship->apartment->square_meters}} m²</span></li>
                                          </ul>
                                      </div>
                                      <div data-lon={{$sponsorship->apartment->lon}} data-lat={{$sponsorship->apartment->lat}} id="address">
                                          <p>Indirizzo: <span></span></p>
                                      </div>
                                  </div>
                              </div>
                          </a>
                      @endforeach
                  </div>
                  <div class="normal">
                      @foreach ($apartments as $apartment)
                          @if (!in_array($apartment->id, $apartments_in_page))
                              <a href="{{route("show", ["slug" => $apartment->slug])}}" class="col-12 box d-block" data-id={{$apartment->id}}>
                                  <div class="row">
                                      <div class="img-container col-12 col-md-5">
                                              @if (!$apartment->cover_image)
                                              <img src="{{asset('img/immagine-non-disponibile.gif')}}" alt="">
                                              @else
                                              <img src="{{ asset('storage/' . $apartment->cover_image) }}">
                                              @endif
                                      </div>
                                      <div class="text-container d-flex col-12 col-md-7 flex-column justify-content-between">
                                          <div class="title">
                                              <h2>{{$apartment->description_title}}</h2>
                                              <p class="font-weight-lighter">{{$apartment->description}}</p>
                                          </div>
                                          <div class="features">
                                              <ul>
                                                  <li class="d-none d-md-block">Numero di letti: <span>{{$apartment->number_of_beds}}</span></li>
                                                  <li class="d-none d-md-block">Numero di stanze: <span>{{$apartment->number_of_rooms}}</span></li>
                                                  <li class="d-none d-md-block">Numero di bagni:  <span>{{$apartment->number_of_bathrooms}}</span></li>
                                                  <li class="d-none d-md-block">Grandezza: <span>{{$apartment->square_meters}} m²</span></li>
                                              </ul>
                                          </div>
                                          <div data-lon={{$apartment->lon}} data-lat={{$apartment->lat}} id="address">
                                              <p>Indirizzo: <span></span></p>
                                          </div>
                                      </div>
                                  </div>
                              </a>
                          @endif
                      @endforeach
                      @if ($apartments->isEmpty() && $sponsorships->isEmpty())
                          <h3 class="text-center mt-3">Nessun appartamento trovato</h3>
                      @endif
                  </div>
              @endif

        </div>
      </section>
  </main>
@endsection

{{-- <!DOCTYPE html>
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
                      <option value="5">5 Km</option>
                      <option value="10">10 Km</option>
                      <option value="15">15 Km</option>
                      <option value="20">20 Km</option>
                      <option value="25">25 Km</option>
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
</html> --}}
