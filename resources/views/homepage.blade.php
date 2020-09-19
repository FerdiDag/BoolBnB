@extends('layouts.app')
@section("page-title","Homepage")
@section('content')
  <main>
      <div id="homepage" class="container">
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{route("advanced")}}" class="advanced_link">Vai alla ricerca avanzata</a>
            </div>
            <form id="simple-search" class="w-100" action="{{ route('search') }}" method="get">
                @csrf
                <div class="input-group mb-3 search-bar form-group">
                  <input id="search" name="search" type="search" class="algolia form-control input-search" placeholder="Dove vuoi andare?" aria-describedby="basic-addon2">
                  <input id="add_lon" type="hidden" name="lon" value="">
                  <input id="add_lat" type="hidden" name="lat" value="">
                  <div class="input-group-append button-box">
                      <button class="btn btn-outline-secondary" id="search-button" type="submit">
                      <i class="fas fa-search"></i>
                        <span class="d-none d-md-inline">Cerca</span>
                      </button>
                  </div>
              </div>
              @error('search')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </form>
            </div>
          </div>
        </div>
      </div>
      <section class="in-evidenza">
        <div class="container">
          <div class="row">
            <div id="index" class="container-fluid">
                <div class="row">
                    <h1 class="w-100 text-center">Appartamenti in evidenza</h1>
                    @foreach ($sponsorships as $sponsorship)
                      @foreach ($sponsorship->payments as $payment)
                        @if ($payment->status == "accepted" && $sponsorship->apartment->visibility == true)
                          <a href="{{route("show", ["slug" => $sponsorship->apartment->slug])}}" class="col-12 box" data-id={{$sponsorship->apartment->id}}>
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
                        @endif
                      @endforeach
                    @endforeach
                </div>
            </div>
        </div>
          </div>
        </div>
      </section>
  </main>
@endsection
