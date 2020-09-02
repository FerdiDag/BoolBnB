<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  // protected $fillable = ['cover_image'];

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
