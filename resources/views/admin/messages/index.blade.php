@extends('layouts.dashboard')
@section('page-title', "Lista messaggi")

@section('content')
    <div id="messages-index" class="container-fluid">
        <div class="row justify-content-around">
            <div class="col-12">
                <h1 class="text-center">I tuoi messaggi</h1>
                @if ($messages->count() > 0)
                    <h5 class="text-center text-md-right">Messaggi non letti: <span>{{$messages->where("status", "=","unread")->count()}}</span></h5>
                @endif
            </div>
            @forelse ($messages as $message)
                <a href="{{route('admin.show_message', ['message' => $message->id])}}" class="col-12 box {{$message->status == "unread" ? "unread" : ""}}">
                    <div class="row">
                        <div class="text-container d-flex align col-12 flex-column justify-content-between">
                            <div class="features">
                                <ul class="mb-0">
                                    <li class="guest">Ricevuto da: <span>{{$message->email}}</span></li>
                                    <li>Data: <span>{{date('d/m/Y H:i', strtotime($message->created_at))}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <h2 class="font-weight-bold">Appartamento: <span class="text-uppercase font-weight-normal">{{$message->apartment->description_title}}</span></h2>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-12 mt-3 text-left">Nessun messaggio ricevuto</p>
            @endforelse
        </div>
    </div>
@endsection
