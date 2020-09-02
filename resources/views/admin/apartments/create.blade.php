@extends('layouts.dashboard')

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
        <form class="" action="" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group m-auto col-12 col-sm-12 col-md-10">
            <label for="apartment-title"></label>
            <input class="form-control" type="text" name="description_title" value="{{old('description_title')}}" placeholder="Inserisci titolo" id="apartment-title">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group m-auto col-12 col-md-10">
            <label for="image"></label>
            <input type="file" name="cover_image" class="form-control-file" id="image" value="">
          </div>
          <div class="form-group m-auto col-10 col-sm-12 col-md-10">
              <label for="description-apartment"></label>
              <textarea class="col-12 col-sm-12" id="description-apartment" name="description" rows="8" cols="80" placeholder="Inserisci descrizione"></textarea>
          </div>
          <div class="form-group m-auto col-12 col-sm-12 col-md-10">
            <label for="address"></label>
            <input type="text" class="form-control" id="address" placeholder="Inserisci indirizzo">
          </div>
          <div class="numbers-form">
            <div class="form-group col-12 col-lg-6 col-sm-6 col-md-5">
              <label for="rooms-number"></label>
              <input class="form-control" type="number" name="number_of_rooms" value="{{old('number_of_rooms')}}" id="rooms-number" placeholder="Inserisci il numero di stanze">
              @error('author')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group col-12 col-lg-6 col-sm-6 col-md-5">
              <label for="beds-number"></label>
              <input class="form-control" type="number" name="number_of_beds" value="{{old('number_of_beds')}}" id="beds-number" placeholder="Inserisci il numero di letti">
              @error('author')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="numbers-form">
            <div class="form-group col-12 col-lg-6 col-sm-6 col-md-5">
              <label for="bathrooms-number"></label>
              <input class="form-control" type="number" name="number of bathrooms" value="{{old('number_of_bathrooms')}}" id="bathrooms-number" placeholder="Inserisci il numbero di bagni">
              @error('author')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="form-group col-12 col-lg-6 col-sm-6 col-md-5">
              <label for="meters"></label>
              <input class="form-control" type="number" name="square_meters" value="{{old('square_meters')}}" id="meters" placeholder="Inserisci metri quadrati">
              @error('author')
                  <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Wifi</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Posto Macchina</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Piscina</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Portineria</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Sauna</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">Vista Mare</label>           
          </div>

          <div class="text-center form-group">
            <button class="btn btn-primary btn-sm add-apartment" type="submit" name="button">Aggiungi appartamento</button>
          </div>
          </form>
      </div>
    </div>
  </div>
@endsection
