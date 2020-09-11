@extends('layouts.dashboard')

@section('content')
    <div id="messages-index" class="container-fluid">
        <div class="row justify-content-around">
            @foreach ($apartments as $apartment)
                <a href="*" class="col-12 box" data-id={{$apartment->id}}>
                    <div class="row">
                        <div class="img-container col-12 col-md-5 col-lg-3 d-none d-md-block">
                                @if (!$apartment->cover_image)
                                <img src="{{asset('img/immagine-non-disponibile.gif')}}" alt="">
                                @else
                                <img src="{{ asset('storage/' . $apartment->cover_image) }}">
                                @endif
                        </div>
                        <div class="text-container d-flex col-12 col-md-7 col-lg-9 flex-column justify-content-between">
                            <div class="title mb-3">
                                <h2>{{$apartment->description_title}}</h2>
                            </div>
                            <div class="features">
                                <ul>
                                    <li>Messaggi non letti: <span>{{$apartment->messages->where("status", "=", "unread")->count()}}</span></li>
                                    <li>Totali messaggi: <span>{{$apartment->messages->count()}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
