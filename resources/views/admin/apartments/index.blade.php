@extends('layouts.dashboard')
@section('content')
<h1 class="text-center">Lista appartamenti</h1>
<div class="container" id="index">
    @foreach ($apartments as $apartment)
      <a href="{{route('admin.apartments.show', ['apartment' => $apartment->id])}}">
        <div class="box">
          <h5 id="index-box-title" class="title text-center">{{$apartment->description_title}}</h5>
          @if (!$apartment->cover_image)
            <img class="rounded" src="{{asset('img/Immagine_non_disponibile.jpg')}}" alt="">
          @else
            <img class="rounded" src="{{ asset('storage/' . $apartment->cover_image) }}">
          @endif
            <div class="features text-center">
                <h5 class="info">Numero di stanze: {{$apartment->number_of_rooms}} </h5>
                <h5 class="info">Numero di letti: {{$apartment->number_of_beds}} </h5>
                <h5 class="info">Numero di bagni: {{$apartment->number_of_bathrooms}}</h5>
                <h5 class="info">Superficie: {{$apartment->square_meters}}</h5>
                <h5 class="info" data-lon="{{$apartment->lon}}" data-lat="{{$apartment->lat}}">Indirizzo: <span></span> </h5>
            </div>
        </div>
      </a>
    @endforeach
</div>
@endsection
