<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use App\Apartment;
use Auth;

class MessageController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            "email" => 'required|string|email|max:255',
            "text" => 'required|string|min:30'
        ]);

        $new_message = new Message();
        $data = $request->all();
        $data['status'] = "unread";
        $data["apartment_id"] = $request->apartment_id;
        $new_message->fill($data);
        $new_message->save();

        $apartment = Apartment::find($request->apartment_id);

        return redirect()->route("show", ["slug" => $apartment->slug])->with("messages", "Messaggio inviato con successo");
    }

    public function index() {
        $apartments = Apartment::where("user_id", Auth::user()->id)->get();
        return view("admin.messages.index", compact("apartments"));
    }
}
