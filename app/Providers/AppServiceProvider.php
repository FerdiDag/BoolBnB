<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Gateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $gateway = new \Braintree\Gateway([
          'environment' => 'sandbox',
          'merchantId' => 'xvc66dz98xy9sznz',
          'publicKey' => 'jx437d66k4p2nn74',
          'privateKey' => 'c56653d27a5707ee57a936747e321357'
      ]);
    }
}
