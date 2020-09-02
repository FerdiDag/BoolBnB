@extends('layouts.dashboard')
@section('content')
<h1 class="text-center">Lista appartamenti</h1>
<div class="container" id="index">
    @foreach ($apartments as $apartment)
      <a href="{{route('admin.apartments.show', ['apartment' => $apartment->id])}}">
        <div class="box" data-id="{{$apartment->id}}">
          <h5 id="index-box-title" class="font-weight-bold title text-center">{{$apartment->description_title}}</h5>
          @if (!$apartment->cover_image)
            <img class="rounded" src="{{asset('img/immagine-non-disponibile.gif')}}" alt="">
          @else
            <img class="rounded" src="{{ asset('storage/' . $apartment->cover_image) }}">
          @endif
            <div class="features text-center">
                <h5 class="info"><strong>Numero di stanze:</strong> <span>{{$apartment->number_of_rooms}}</span></h5>
                <h5 class="info"><strong>Numero di letti:</strong> <span>{{$apartment->number_of_beds}}</span> </h5>
                <h5 class="info"><strong>Numero di bagni:</strong> <span>{{$apartment->number_of_bathrooms}}</span></h5>
                <h5 class="info"><strong>Superficie:</strong> <span>{{$apartment->square_meters}}</span>{{" m²"}}</h5>
                <h5 id="address" class="info" data-lon="{{$apartment->lon}}" data-lat="{{$apartment->lat}}"><strong>Indirizzo:</strong> <span></span> </h5>
            </div>
        </div>
      </a>
    @endforeach
</div>
@endsection
