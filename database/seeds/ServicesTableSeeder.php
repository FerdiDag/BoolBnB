<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $services = config('data.services');

      foreach ($services['type'] as $service) {
        $newService = new Service();
        $newService->type = $service;
        $newService->save();
      }
    }
}
