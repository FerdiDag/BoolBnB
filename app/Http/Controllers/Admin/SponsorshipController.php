<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Auth;
use App\Rate;

class SponsorshipController extends Controller
{
    public function index(Apartment $apartment)
    {
        if ($apartment->user_id != Auth::user()->id) {
            return abort("404");
        };
        $rates = Rate::all();
        $data = [
            "apartment" => $apartment,
            "rates" => $rates
        ];
        return view("admin.sponsorship.make", $data);
    }
}
