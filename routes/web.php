<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@homepage')->name('home');
Route::get('/search', 'SearchController@simplysearch')->name('search');
Route::get('/advanced', 'SearchController@advanced_search')->name("advanced");
Route::get('/show/{slug}', 'HomeController@show')->name('show');
Route::post('/message/create{apartment}', 'Admin\MessageController@create')->name('create_message');


Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('/apartments', 'ApartmentController');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/create', function () {
        return view('admin.apartments.create');
    });
    Route::get('/show', function () {
        return view('admin.apartments.show');
    });
    Route::get('/sponsorship/{apartment}', "SponsorshipController@index")->name("sponsorship");
    Route::post('/sponsorship/{apartment}', 'SponsorshipController@submit')->name('sponsorshipsubmit');
    Route::get('/messages', 'MessageController@index')->name('index_message');
    Route::get('/messages/{message}', 'MessageController@show')->name('show_message');
    Route::get('/stats', 'StatsController@index')->name('index_stats');
    Route::get('/stats/{apartment}', 'StatsController@show')->name('show_stats');

});
