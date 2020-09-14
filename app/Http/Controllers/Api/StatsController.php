<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Message;
use Auth;

class StatsController extends Controller
{
    public function messages(Request $request){
        $apartment = Apartment::where("user_id","=", Auth::user()->id)->get();
        $messages = Message::where("apartment_id", $request->apartment_id);
        if ($messages->isEmpty()) {
            return response()->json([
                "success"=>true,
                "length"=>$messages->count(),
                "error"=>"Nessun messaggio trovato",
                "results"=>[]
            ]);
        };
        if (!$apartment) {
            return response()->json([
                "success"=>false,
                "error"=>"Nessun appartamento trovato"
            ]);
        }

                return response()->json([
                    "success"=>true,
                    "length"=>$messages->count(),
                    "results"=>$messages

            ]);

    }
}
