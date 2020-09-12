@extends('layouts.dashboard')
@section('page-title', "Dettagli messaggio")

@section('content')
  <div id="show-message" class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">
        <h1>Dettagli messaggio</h1>
      </div>
      <div class="col-12">
        <p class="mb-1"><span class="font-weight-bold">Appartamento di riferimento : </span>{{$message->apartment->description_title}}</p>
        <p class="mb-1"><span class="font-weight-bold">Email mittente : </span> {{$message->email}}</p>
        <p class="data-message mb-1"><span class="font-weight-bold">Data di ricezione : </span>{{date('d/m/Y H:i', strtotime($message->created_at))}}</p>
      </div>
      <div class="col-12 mt-2">
        <p class="font-weight-bold text-center mb-3">Testo</p>
        <p class="message-text">{{$message->text}}</p>
      </div>
    </div>
  </div>
@endsection
