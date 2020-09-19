@extends('layouts.app')
@section("page-title","La tua ricerca")

@section('content')
    {{-- @php
        dd($address);
    @endphp --}}
  <main id="index">
      <div id="advanced-search" class="container">
        <div class="row">
          <div class="box-advanced-search mb-3">
            <div class="input-group mb-3 search-bar">
              <input id="search" type="search" class="algolia form-control input-search" placeholder="Dove vuoi andare?"  value="{{isset($address) ? $address : ''}}">
              <input id="add_lon" type="hidden" name="" value="">
              <input id="add_lat" type="hidden" name="" value="">
              <div class="input-group-append button-box">
              <button class="btn btn-outline-secondary" id="search-button" type="button">
              <i class="fas fa-search"></i>
                <span class="d-none d-md-inline">Cerca</span>
              </button>
              </div>
            </div>
              <div id="services" class="form-group w-80 filter-search">
                <div class="number-services-box d-flex justify-content-sm-center justify-content-center flex-wrap">
                  @foreach ($services as $service)
                      <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" id="services-advanced-search" name="services[]" type="checkbox" value="{{$service->id}}">
                              {{$service->type}}
                          </label>
                      </div>
                  @endforeach
                </div>
              </div>
            <div class="number-box-filters d-md-flex justify-content-center">
              <div class="form-group select-option col-sm-12 col-md-3">
                <label for="number_of_rooms">Numero di stanze :</label>
                <select class="form-control" id="number_of_rooms" >
                  <option value="1">1</option>
                  @for ($i=2; $i < 31; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group select-option col-sm-12 col-md-3">
                <label for="number_of_beds">Numero di letti :</label>
                <select class="form-control" id="number_of_beds">
                  <option value="1">1</option>
                  @for ($i=2; $i < 31; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group select-option col-sm-12 col-md-3">
                <label for="Km">Km :</label>
                <select class="form-control" id="km">
                  <option value="20">20 Km</option>
                  @for ($i=30; $i <= 70; $i=$i + 10)
                    <option value="{{$i}}">{{$i}} Km</option>
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
              @else
                  <div class="marked"></div>
                  <div class="normal"></div>
              @endif

        </div>
      </section>
  </main>
  <script id="apartment-box" type="text/x-handlebars-template">
      <a href="http://localhost:8888/proj13_team6/public/show/@{{slug}}" class="col-12 box d-block" data-id="@{{id}}">
          <div class="row">
              <div class="img-container col-12 col-md-5">
                  <img src="http://localhost:8888/proj13_team6/public/storage/@{{image}}">
              </div>
              <div class="text-container d-flex col-12 col-md-7 flex-column justify-content-between">
                  <div class="title">
                      <h2>@{{title}}</h2>
                      <p class="font-weight-lighter">@{{description}}</p>
                  </div>
                  <div class="features">
                      <ul>
                          <li class="d-none d-md-block">Numero di letti: <span>@{{beds}}</span></li>
                          <li class="d-none d-md-block">Numero di stanze: <span>@{{rooms}}</span></li>
                          <li class="d-none d-md-block">Numero di bagni:  <span>@{{bathrooms}}</span></li>
                          <li class="d-none d-md-block">Grandezza: <span>@{{square_meters}} m²</span></li>
                      </ul>
                  </div>
                  <div data-lon='@{{lon}}' data-lat='@{{lat}}' id="address">
                      <p>Indirizzo: <span></span></p>
                  </div>
              </div>
          </div>
      </a>
  </script>
@endsection
