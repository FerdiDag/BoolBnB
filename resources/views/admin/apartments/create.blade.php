@extends('layouts.dashboard')
@section('page-title', "Aggiungi appartamento")
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="add-apartment-title text-center">
                    <h1 class="mt-3 mb-3">Aggiungi un nuovo appartamento </h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="m-auto">
                <form action="{{route("admin.apartments.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="apartment-title"></label>
                        <input class="form-control" type="text" name="description_title" value="{{old('description_title')}}" placeholder="Inserisci titolo" id="apartment-title">
                        @error('description_title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class=" mt-3 text-left d-block" for="image">Aggiungi immagine:</label>
                        <input type="file" name="cover_image" class="form-control-file" id="image">
                    </div>
                    <div class="form-group">
                        <label for="description-apartment"></label>
                        <textarea class="col-12 col-sm-12"  id="description-apartment" name="description" rows="8" cols="80" placeholder="Inserisci descrizione">{{old('description')}}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="address"></label>
                            <div class="input-group-append">
                                <a id="add_address" class="btn btn-outline-secondary">Aggiungi</a>
                            </div>
                            <input id="address" name="address" value="{{old("address")}}" type="text" class="algolia form-control" placeholder="Inserisci indirizzo">
                            <label id="status_load" class="errore"></label>
                            <input type="hidden" id="add_lat" name="lat" value="{{old("lat")}}">
                            <input type="hidden" id="add_lon" name="lon" value="{{old('lon')}}">
                            @error('address')
                                <small class="w-100 d-block text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="rooms-number"></label>
                            <input class="form-control" type="number" name="number_of_rooms" value="{{old('number_of_rooms')}}" id="rooms-number" placeholder="Inserisci il numero di stanze">
                            @error('number_of_rooms')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="beds-number"></label>
                            <input class="form-control" type="number" name="number_of_beds" value="{{old('number_of_beds')}}" id="beds-number" placeholder="Inserisci il numero di letti">
                            @error('number_of_beds')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="bathrooms-number"></label>
                            <input class="form-control" type="number" name="number_of_bathrooms" value="{{old('number_of_bathrooms')}}" id="bathrooms-number" placeholder="Inserisci il numbero di bagni">
                            @error('number_of_bathrooms')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="meters"></label>
                            <input class="form-control" type="number" name="square_meters" value="{{old('square_meters')}}" id="meters" placeholder="Inserisci metri quadrati">
                            @error('square_meters')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div id="services" class="form-group">
                        Servizi :
                        @foreach ($services as $service)
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                    class="form-check-input" name="services[]" type="checkbox" value="{{$service->id}}">
                                    {{$service->type}}
                                </label>
                            </div>
                        @endforeach
                        @error('services')
                            <small class="d-block text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                        <button id="send_form" class="btn btn-primary btn-sm add-apartment" type="submit">
                            Aggiungi appartamento
                        </button>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection
