<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use App\Apartment;
use Auth;

class MessageController extends Controller
{
    public function create(Request $request,Apartment $apartment) {
        $request->validate([
            "email" => 'required|string|email|max:255',
            "text" => 'required|string|min:15'
        ]);

        $new_message = new Message();
        $data = $request->all();
        $data['status'] = "unread";
        $data["apartment_id"] = $apartment->id;
        $new_message->fill($data);
        $new_message->save();

        return redirect()->route("show", ["slug" => $apartment->slug])->with("messages", "Messaggio inviato con successo");
    }

    public function index() {
        $messages = Message::with("apartment")->get()->where("apartment.user_id","=", Auth::user()->id)->sortByDesc("created_at");
        return view("admin.messages.index", compact("messages"));
    }

    public function show(Message $message) {
        if ($message->apartment->user_id != Auth::user()->id) {
          return abort('404');
        }

        $message->update(['status' => 'read']);

        return view('admin.messages.show', compact('message'));
    }
}
