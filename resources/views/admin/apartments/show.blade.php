@extends('layouts.dashboard')

@section('page-title', 'Dettaglio appartamento')

@section('content')
<div id="show-header" class="container">
    <div class="row">
        <div class="col-md-6">
            <h1 id="detail-title">{{$apartment->description_title}}</h1>
        </div>
        <div id="show-header-right" class="col-md-6 col-sm-12">
            <div id="visibility-switch" class="custom-control custom-switch switch-danger">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                <label class="custom-control-label" for="customSwitch1">Visibile</label>
            </div>
            <button id="modify-button" type="button" class="btn btn-default" name="button">Modifica</button>
            <form class="d-inline" action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-default" value="Elimina">
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
                <li>Metri quadrati: <span>{{$apartment->square_meters}}</span>{{" m²"}}</li>
            </ul>
        </div>

        <div id="show-services" class="col-md-6 col-sm-4">

            <ul aria-label="Servizi">
                @foreach ($apartment->services as $service)
                <li>{{$service->type}}</li>
                @endforeach
            </ul>
        </div>

    </div>

</div>
@endsection
