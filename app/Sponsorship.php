<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = ["apartment_id", "rate_id", "expiry_date"];

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
