@extends('layouts.app')

@yield('page-title, homepage')

@section('content')
  <main>
      <div class="container">
        <div class="row">
          <div class="input-group mb-3 search-bar">
            <input id="search" type="search" class="form-control input-search" placeholder="Dove vuoi andare?" aria-describedby="basic-addon2">
            <div class="input-group-append button-box">
            <button class="btn btn-outline-secondary" id="search-button" type="button">
            <i class="fas fa-search"></i>
              Cerca
            </button>
            </div>
          </div>
          <div class="w-100 d-flex justify-content-around">
            <div class="form-group">
              <label for="number_of_rooms"></label>
              <select class="form-control" id="number_of_rooms" >
                <option value="">Stanze</option>
                @for ($i=1; $i < 31; $i++)
                  <option>{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <label for="number_of_beds"></label>
              <select class="form-control" id="number_of_beds">
                <option value="">Letti</option>
                @for ($i=1; $i < 31; $i++)
                  <option>{{$i}}</option>
                @endfor
              </select>
            </div>
            <div class="form-group">
              <label for="number_of_bathrooms"></label>
              <select class="form-control" id="number_of_bathrooms">
                <option value="">Km</option>
                <option value="">5 Km</option>
                <option value="">10 Km</option>
                <option value="">15 Km</option>
                <option value="">20 Km</option>
              </select>
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
        </div>
      </div>
      <section class="in-evidenza">
        <div class="container">
          <div class="row">
            <div class="text-center w-100">
              <h1 >In Evidenza :</h1>
            </div>
            <div class="d-flex justify-content-around box-in-evidenza">

            </div>
          </div>
        </div>
      </section>
  </main>
@endsection
