<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  public function views() {
    return $this->hasMany('App\View');
  }

  public function messages() {
    return $this->hasMany('App\Message');
  }
  
  public function sponsorships() {
    return $this->hasMany('App\Sponsorship');
  }

}
