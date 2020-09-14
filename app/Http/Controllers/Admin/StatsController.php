<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Auth;

class StatsController extends Controller
{
  public function index() {
    $apartments = Apartment::where('user_id', Auth::user()->id)->get();
    return view('admin.stats.index', compact('apartments'));
  }

  public function show($id) {
    $apartment = Apartment::where('id', '=', $id)->get()->where('user_id', '=', Auth::user()->id)->first();

    if (!$apartment) {
      return abort('404');
    }

    $data = [
      'apartment' => $apartment,
      'api_token' => Auth::user()->api_token
    ];
    return view('admin.stats.show', $data);
  }
}
