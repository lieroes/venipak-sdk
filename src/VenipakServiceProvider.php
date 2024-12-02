<?php

namespace VenipakSDK;

use Illuminate\Support\ServiceProvider;

class VenipakServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(VenipakClient::class, function ($app) {
            $config = config('venipak');
            return new VenipakClient($config['base_url'], $config['api_key']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/venipak.php' => config_path('venipak.php'),
        ]);
    }
}