@extends('layouts.app')

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
