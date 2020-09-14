@extends('layouts.dashboard')
@section('page-title', "Statistiche")

@section('content')
  <div id="stats-show" class="row" data-id="{{$apartment_id}}" data-token="{{$api_token}}">
    <div class="col-12 text-center">
      <h1>Statistiche per l'appartamento : <span></span> </h1>
    </div>
    <div class="col-md-6">
      <div class="chart-info">
        <p></p>
        <div class="chart-wrapper">
          <canvas id="chart-message"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <p></p>
      <div class="chart-wrapper">
        <canvas id="chart-stats"></canvas>
      </div>
    </div>
  </div>
@endsection
