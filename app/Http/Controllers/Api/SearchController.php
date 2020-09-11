<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Sponsorship;
use App\Apartment;

class SearchController extends Controller
{


    public function sponsorship(Request $request) {
        $lat = $request->lat;
        $lon = $request->lon;
        $number_of_beds = $request->number_of_beds;
        $number_of_rooms = $request->number_of_rooms;
        $number_of_bathrooms = $request->number_of_bathrooms;
        $range = $request->range;
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();
        $sponsorships = Sponsorship::join('payments','payments.sponsorship_id', '=', 'sponsorships.id')->join('apartments', 'sponsorships.apartment_id', '=', 'apartments.id')->where('sponsorships.expiry_date', '>', $current_timestamp)->where('apartments.visibility', '=', true)->where('apartments.number_of_rooms', '>=', $number_of_rooms)->where('apartments.number_of_beds', '>=' ,$number_of_beds)->where('apartments.number_of_bathrooms', '>=', $number_of_bathrooms)->where('status','=','accepted')->select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))
        ->having('distance', '<', $range)->orderByDesc('expiry_date')->get();

        if ($sponsorships->isEmpty()) {
            return response()->json([
                    'success' => true,
                    'length' => $sponsorships->count(),
                    "error" => "Nessun appartamento sponsorizzato trovato",
                    'results' => []
            ]);

        } else {
            return response()->json([
                    'success' => true,
                    'length' => $sponsorships->count(),
                    'results' => $sponsorships
            ]);
        }
    }

    public function apartments(Request $request) {
        $lat = $request->lat;
        $lon = $request->lon;
        $number_of_beds = $request->number_of_beds;
        $number_of_rooms = $request->number_of_rooms;
        $number_of_bathrooms = $request->number_of_bathrooms;
        $range = $request->range;
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();

        $apartments = Apartment::with("services")->select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))->where('visibility', '=', true)->where('apartments.number_of_rooms', '>=', $number_of_rooms)->where('apartments.number_of_beds', '>=' ,$number_of_beds)->where('apartments.number_of_bathrooms', '>=', $number_of_bathrooms)->having('distance', '<', $range)->orderByDesc('distance')->get();

        if ($apartments->isEmpty()) {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->count(),
                    "error" => "Nessun appartamento sponsorizzato trovato",
                    'results' => []
            ]);

        } else {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->count(),
                    'results' => $apartments
            ]);
        }
    }
}
