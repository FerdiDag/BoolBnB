@extends('layouts.dashboard')
@section('page-title', "Statistiche")

@section('content')
    <div id="stats-index" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Statistiche appartamenti</h1>
                <p class="text-center">Seleziona un appartamento per visualizzare le statistiche</p>
            </div>
            <div class="col-12">
              <ul>
                @foreach ($apartments as $apartment)
                      <li class="w-100 mt-3 mb-3 stat-items">
                        <a href="{{route('admin.show_stats', ['apartment' => $apartment->id])}}">{{$apartment->description_title}}</a>
                      </li>
                @endforeach
              </ul>
            </div>
        </div>
    </div>
@endsection
