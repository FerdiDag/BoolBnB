<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('user_id', Auth::user()->id)->get()->count();
        return view('admin.home', compact('apartments'));
    }

}
