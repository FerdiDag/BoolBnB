<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sponsorship;
use App\Apartment;
use App\Service;
use App\View;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function homepage(Apartment $apartment)
    {
        //definisco la data di scadenza con CARBON
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();

        //recupero la sponsorizzazione in database più recente, dell'appartamento in oggetto
        $sponsorships = Sponsorship::where("expiry_date", ">", $current_timestamp)->get();

        return view('homepage', compact('sponsorships'));
}

        public function show(Apartment $apartment)
        {
          $new_view = new View();
          $data = [
            'apartment_id' => $apartment->id
          ];
          $new_view->fill($data);
          $new_view->save();

          return view('show', compact('apartment'));
        }

        public function search()
        {
            $services = Service::all();
            return view('search', compact("services"));
        }
}
