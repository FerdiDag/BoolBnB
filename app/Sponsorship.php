<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
  public function payments() {
    return $this->hasMany('App\Payment');
  }

  public function apartment() {
    return $this->belongsTo('App\Apartment');
  }

  public function rate() {
    return $this->belongsTo('App\Rate');
  }
}
