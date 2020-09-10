<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class SearchController extends Controller
{
    public function simplysearch(Request $request) {
        $services = Service::all();
        $request->validate([
            'search' => 'required|string'
        ]);
    }


}
