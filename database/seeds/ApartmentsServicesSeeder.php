<?php

use Illuminate\Database\Seeder;
use App\Apartment;

class ApartmentsServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 3; $i++) {
            $apartments = Apartment::find($i);
            $apartments->services()->attach(rand(1, 6));
        }
    }
}
