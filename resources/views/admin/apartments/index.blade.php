@extends('layouts.dashboard')
@section('page-title', "I tuoi appartamenti")

@section('content')
    <div id="index" class="container-fluid">
        <div class="row">
            <h1 class="w-100 text-center">I tuoi appartamenti</h1>
            @foreach ($apartments as $apartment)
                <a href="{{route("admin.apartments.show", ["apartment" => $apartment->id])}}" class="col-12 box" data-id={{$apartment->id}}>
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
            @endforeach
        </div>
    </div>
</div>
@endsection
