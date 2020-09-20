@extends('layouts.dashboard')

@section('page-title', 'Home')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-start">
        <div class="col-12">
            @if (Auth::user()->name)
                <h1 class="mb-3">Ciao {{Auth::user()->name}}</h1>
            @else
                <h1 class="mb-3">Ciao</h1>
            @endif
        </div>
        <div class="col-12">
            @if ($apartments > 1)
                <h5 class="mb-3">Hai {{$apartments}} appartamenti registrati.</h5>
            @elseif ($apartments == 1)
                <h5 class="mb-3">Hai 1 appartamento registrato.</h5>
            @else
                <h5 class="mb-3">Non hai nessun appartamento registrato</h5>
            @endif
        </div>
        <div class="col-12">
            <p>Usa il pannello per aggiungere e tenere sotto controllo i tuoi appartamenti.</p>
        </div>
    </div>

</div>
@endsection
