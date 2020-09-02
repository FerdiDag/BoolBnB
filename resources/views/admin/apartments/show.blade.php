@extends('layouts.dashboard')

@section('page-title', 'Dettaglio appartamento')

@section('content')
    <div id="show-header" class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 id="detail-title">Titolo Appartamento</h1>
            </div>
            <div id="show-header-right" class="col-md-6 col-sm-12">
                <div id="visibility-switch" class="custom-control custom-switch switch-danger">
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                  <label class="custom-control-label" for="customSwitch1">Visibile</label>
                </div>
                <button id="modify-button" type="button" class="btn btn-default" name="button">Modifica</button>
                <button id="delete-button" type="button" class="btn btn-default" name="button">Elimina</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div id="show-image" class="col-md-6 offset-md-0 col-sm-12">
                <img src="" alt="">
            </div>
            <div id="show-description" class="col-md-6 offset-md-0 col-sm-12">
                <p><span>Descrizione: </span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div id="show-info" class="col-md-6 col-sm-8">
                <ul aria-label="Informazioni">
                    <li><span>Indirizzo: </span></li>
                    <li><span>Numero di stanze: </span></li>
                    <li><span>Numero posti letto: </span></li>
                    <li><span>Numero bagni: </span></li>
                    <li><span>Metri quadrati: </span></li>
                </ul>
            </div>
            <div id="show-services" class="col-md-6 col-sm-4">
                <ul aria-label="Servizi">

                </ul>
            </div>

        </div>

    </div>
@endsection
