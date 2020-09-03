<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  protected $fillable = ["description_title", "description", "number_of_rooms", "number_of_beds", "number_of_bathrooms", "square_meters", "lat", "lon", "cover_image", "slug", "visibility", "user_id"];

  public function views() {
    return $this->hasMany('App\View');
  }

  public function messages() {
    return $this->hasMany('App\Message');
  }

  public function sponsorships() {
    return $this->hasMany('App\Sponsorship');
  }

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function services() {
    return $this->belongsToMany('App\Service');
  }
}
