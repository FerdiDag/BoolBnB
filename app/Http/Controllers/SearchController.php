<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Carbon\Carbon;
use App\Sponsorship;
use App\Apartment;

class SearchController extends Controller
{
    public function simplysearch(Request $request) {
        $services = Service::all();
        $request->validate([
            'search' => 'required|string',
            "lon" => "required",
            "lat" => "required"
        ]);

        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();
        $lat = $request->lat;
        $lon = $request->lon;
        // dd($lon);
        $sponsorship_apartment = Sponsorship::with('apartment')->get()->where('expiry_date', '>', $current_timestamp)->where('apartment.visibility', '=', true)->where('apartment.lat', '=', $lat)->where('apartment.lon', '=', $lon)->sortByDesc('created_at');
        $apartment = Apartment::all()->where('visibility', '=', true)->where('lat', '=', $lat)->where('lon', '=', $lon)->sortByDesc('created_at');
        dd($apartment);
    }



}
