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
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();
        $services = explode(',', $request->services);
        $lon = $request->lon;
        $lat = $request->lat;
        $number_of_rooms = $request->number_of_rooms;
        $number_of_beds = $request->number_of_beds;
        $range = $request->range;

        $apartments = Apartment::select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))->join("sponsorships", "apartments.id", "=", "sponsorships.apartment_id")->join("payments", "sponsorships.id", "=", "payments.sponsorship_id")->where("expiry_date", ">", $current_timestamp)
        ->where("payments.status", "=", "accepted")
        ->where('visibility', '=', true)->where('apartments.number_of_rooms', '>=', $number_of_rooms)->where('apartments.number_of_beds', '>=' ,$number_of_beds)->having('distance', '<', $range)->orderByDesc('sponsorships.created_at');
        foreach($services as $service) {
            $apartments->whereHas('services', function ($query) use($service) {
                $query->where('type', $service);
            });
        };

        if ($apartments->get()->isEmpty()) {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->get()->count(),
                    "error" => "Nessun appartamento trovato",
                    'results' => []
            ]);

        } else {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->get()->count(),
                    'results' => $apartments->get()
            ]);
        }
    }

    public function apartments(Request $request) {
        $services = explode(',', $request->services);
        $lon = $request->lon;
        $lat = $request->lat;
        $number_of_rooms = $request->number_of_rooms;
        $number_of_beds = $request->number_of_beds;
        $range = $request->range;

        $apartments = Apartment::with("services")->select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))->where('visibility', '=', true)->where('apartments.number_of_rooms', '>=', $number_of_rooms)->where('apartments.number_of_beds', '>=' ,$number_of_beds)->having('distance', '<', $range)->orderBy('distance');
        foreach($services as $service) {
            $apartments->whereHas('services', function ($query) use($service) {
                $query->where('type', $service);
            });
        };

        if ($apartments->get()->isEmpty()) {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->get()->count(),
                    "error" => "Nessun appartamento trovato",
                    'results' => []
            ]);

        } else {
            return response()->json([
                    'success' => true,
                    'length' => $apartments->get()->count(),
                    'results' => $apartments->get()
            ]);
        }
    }
}
