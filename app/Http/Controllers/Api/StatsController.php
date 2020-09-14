<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Message;
use App\View;
use Auth;

class StatsController extends Controller
{
    public function messages(Request $request){
        $apartment = Apartment::where("user_id","=", auth('api')->user()->id)->get()->where("id", $request->apartment_id)->first();

        if (!$apartment) {
            return response()->json([
                "success"=> false,
                "error"=>"Nessun appartamento trovato"
            ]);
        }

        $messages = Message::where("apartment_id", $request->apartment_id)->get();

        if ($messages->isEmpty()) {
            return response()->json([
                "success"=>true,
                "length"=>$messages->count(),
                "error"=>"Nessun messaggio trovato",
                "results"=>[]
            ]);
        };

        return response()->json([
            "success"=>true,
            "length"=>$messages->count(),
            "results"=>$messages
        ]);
    }

    public function views(Request $request){
        $apartment = Apartment::where("id", $request->apartment_id)->first();

        $views = View::where("apartment_id", $request->apartment_id)->get();

        if ($views->isEmpty()) {
            return response()->json([
                "success"=> true,
                "length"=> $views->count(),
                "error"=> "Nessun messaggio trovato",
                "results"=> []
            ]);
        };

        return response()->json([
            "success"=> true,
            "length"=> $views->count(),
            "results"=> $views
        ]);
    }
}
