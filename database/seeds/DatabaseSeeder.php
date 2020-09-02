<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ApartmentsTableSeeder::class);
        // $this->call(RatesTableSeeder::class);
        // $this->call(ServicesTableSeeder::class);
        $this->call(ApartmentsServicesSeeder::class);
    }
}
