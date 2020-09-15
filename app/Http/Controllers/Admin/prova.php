<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;

class prova extends Controller
{
    public function prova(Request $request) {

        $services = ["Wifi"];
        $lon = 11.25693;
        $lat = 43.7687;
        $number_of_rooms= 1;
        $number_of_bathrooms = 1;
        $number_of_beds = 1;
        $range = 400;

        $apartments = Apartment::with("services")->select(Apartment::raw('*, ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.$lon.') ) + sin( radians('.$lat.') ) * sin( radians( lat ) ) ) ) AS distance'))->where('visibility', '=', true)->where('apartments.number_of_rooms', '>=', $number_of_rooms)->where('apartments.number_of_beds', '>=' ,$number_of_beds)->where('apartments.number_of_bathrooms', '>=', $number_of_bathrooms)->having('distance', '<', $range)->orderBy('distance');
        foreach($services as $service) {
            $apartments->whereHas('services', function ($query) use($service) {
                $query->where('type', $service);
            });
        };
        dd($apartments->get());
    }
}
