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
        $sponsorships = Sponsorship::with("apartment")->get()->where("expiry_date", ">", $current_timestamp)->where("apartment.visibility","=", true)->sortByDesc('created_at');
        return view('homepage', compact('sponsorships'));
    }

        public function show($slug)
        {
            $apartment = Apartment::where("slug", $slug)->first();

            if(!$apartment) {
                return abort("404");
            }
            if (!session()->has('messages')) {
                $new_view = new View();
                $data = [
                    'apartment_id' => $apartment->id
                ];
                $new_view->fill($data);
                $new_view->save();
            }

          return view('guest.show', compact('apartment'));
        }

}
