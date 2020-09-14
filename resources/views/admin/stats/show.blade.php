@extends('layouts.dashboard')
@section('page-title', "Statistiche")

@section('content')
  <div id="stats-show" class="row" data-id="{{$apartment->id}}" data-token="{{$api_token}}">
    <div class="col-12 text-center mb-3">
      <h1>{{$apartment->description_title}}</h1>
    </div>
    <div class="col-lg-6 mt-3 mb-3">
      <div class="chart-info">
        <p class="text-center"><strong>Messaggi totali: </strong><span id="message-length"></span> </p>
        <div class="chart-wrapper">
          <canvas id="chart-message"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mt-3">
      <p class="text-center"><strong>Visualizzazioni totali: </strong><span id="view-length"></span> </p>
      <div class="chart-wrapper">
        <canvas id="chart-views"></canvas>
      </div>
    </div>
  </div>
@endsection
