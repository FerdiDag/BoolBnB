@extends('layouts.dashboard')
@section('page-title', 'Dettaglio appartamento')
@section("content")
@if (session('messages'))
    <div class="info-sponsorship alert alert-success">
        {{ session('messages') }}
    </div>
@endif
<div id="show-header" class="container">
    <div class="row justify-content-between">
        <div class="col-lg-6">
            <h1 id="detail-title">{{$apartment->description_title}}</h1>
        </div>
        <div id="show-header-right" class="col-lg-6 col-sm-12 d-flex d-lg-block align-items-flex-start justify-md-content-end justify-content-center">
            @if ($sponsorship != null)
                @forelse ($sponsorship->payments as $payment)
                    @if ($loop->last && $payment->status != "accepted")
                        <a id="sponsorship-button" href="{{route("admin.sponsorship", ["apartment" => $apartment->id])}}" type="button" class="btn btn-default" name="button">Sponsorizza</a>
                    @endif
                @empty
                    <a id="sponsorship-button" href="{{route("admin.sponsorship", ["apartment" => $apartment->id])}}" type="button" class="btn btn-default" name="button">Sponsorizza</a>
                @endforelse
            @else
                <a id="sponsorship-button" href="{{route("admin.sponsorship", ["apartment" => $apartment->id])}}" type="button" class="btn btn-default" name="button">Sponsorizza</a>
            @endif
            <a id="modify-button" href="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}" type="button" class="btn btn-default" name="button">Modifica</a>
            <form class="d-inline" action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <input id="delete-button" type="submit" class="btn btn-default" value="Elimina">
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div id="show-image" class="col-md-6 offset-md-0 col-sm-12">
            @if (!$apartment->cover_image)
            <img src="{{asset('img/immagine-non-disponibile.gif')}}" alt="">
            @else
            <img src="{{ asset('storage/' . $apartment->cover_image) }}">
            @endif
        </div>
        <div id="show-description" class="col-md-6 offset-md-0 col-sm-12">
            <p>Descrizione: <span>{{$apartment->description ?? "-"}}</span</p>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div data-id="{{$apartment->id}}" id="show-info" class="col-md-6 col-sm-8">
            <ul aria-label="Informazioni">
                <li id="address" data-lon="{{$apartment->lon}}" data-lat="{{$apartment->lat}}">Indirizzo: <span ></span></li>
                <li>Numero di stanze: <span>{{$apartment->number_of_rooms}}</span></li>
                <li>Numero posti letto: <span>{{$apartment->number_of_beds}}</span></li>
                <li>Numero bagni: <span>{{$apartment->number_of_bathrooms}}</span></li>
                <li>Metri quadrati: <span>{{$apartment->square_meters}} m²</span></li>
            </ul>
            <ul aria-label="Servizi">
                @foreach ($apartment->services as $service)
                <li>{{$service->type}}</li>
                @endforeach
            </ul>
        </div>
        <div id="show-map" class="col-md-6">
            <div id='map'></div>
            <script>
                var lon = {{$apartment->lon}};
                var lat = {{$apartment->lat}};
                var appartamento = [lon, lat];
                var nomeAppartamento = '{{$apartment->description_title}}';

                var map = tt.map({
                    container: 'map',
                    key: 'lxZY3SRkbhxVGTMUwh3haJI69qlwDQ1I',
                    style: 'tomtom://vector/1/basic-main',
                    center: appartamento,
                    zoom: 15,
                });

                var marker = new tt.Marker().setLngLat(appartamento).addTo(map);

                var popupOffsets = {
                    top: [0, 0],
                    bottom: [0, -40],
                    'bottom-right': [0, -70],
                    'bottom-left': [0, -70],
                    left: [25, -35],
                    right: [-25, -35]
                }

                var popup = new tt.Popup({
                    offset: popupOffsets
                }).setHTML(nomeAppartamento);
                marker.setPopup(popup).togglePopup();
            </script>
        </div>
    </div>
</div>
@endsection
