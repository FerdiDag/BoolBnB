<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->namespace("Api")->group(function() {
    Route::get("/stats/messages", "StatsController@messages");
    Route::get("/stats/views", "StatsController@views");
});

Route::get("/advanced/sponsorships", "Api\SearchController@sponsorship");
Route::get("/advanced/apartments", "Api\SearchController@apartments");
