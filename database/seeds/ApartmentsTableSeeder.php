<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

      $apartments = config('data.apartments');

      foreach ($apartments as $apartment) {
        $newApartment = new Apartment();
        $newApartment->description_title = $apartment['description_title'];
        $newApartment->description = $apartment['description'];
        $newApartment->number_of_rooms = $faker->numberBetween(1, 6);
        $newApartment->number_of_beds = $faker->numberBetween(1, 6);
        $newApartment->number_of_bathrooms = $faker->numberBetween(1, 3);
        $newApartment->square_meters = $faker->numberBetween(60, 120);
        $newApartment->lat = $faker->latitude(-90, 90);
        $newApartment->lon = $faker->longitude(-180, 180);
        $newApartment->slug = $apartment['slug'];
        $newApartment->visibility = true;
        $newApartment->user_id = rand(1, 3);
        $newApartment->save();
      }
    }
}
