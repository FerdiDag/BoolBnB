<?php

use Illuminate\Database\Seeder;
use App\Rate;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $rates = config('data.rates');

      foreach ($rates as $rate) {
        $newRate = new Rate();
        $newRate->time = $rate['time'];
        $newRate->price = $rate['price'];
        $newRate->save();
      }
    }
}
