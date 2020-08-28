<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
  public function sponsorships() {
    return $this->hasMany('App\Sponsorship');
  }
}
