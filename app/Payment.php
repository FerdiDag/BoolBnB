<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ["status", "sponsorship_id"];
    public function sponsorship() {
        return $this->belongsTo('App\Sponsorship');
  }
}
