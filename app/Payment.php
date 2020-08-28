<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  public function sponsorship() {
    return $this->belongsTo('App\Sponsorship');
  }
}
