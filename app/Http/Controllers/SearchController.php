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
        $sponsorships = Sponsorship::with('payments')->join('apartments', 'sponsorships.apartment_id', '=', 'apartments.id')->where('sponsorships.expiry_date', '>', $current_timestamp)->where('apartments.visibility', '=', true)->select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))
        ->having('distance', '<', 25)->orderBy('distance')->get();
        $apartments = Apartment::select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))->where('visibility', '=', true)
        ->having('distance', '<', 25)->orderByDesc('created_at')->get();
        dd($apartments);
    }



}
