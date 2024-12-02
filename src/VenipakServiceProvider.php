<?php

namespace VenipakSDK;

use Illuminate\Support\ServiceProvider;

class VenipakServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the VenipakClient to the service container
        $this->app->singleton(VenipakClient::class, function ($app) {
            return new VenipakClient(
                config('venipak.base_url'),
                config('venipak.api_key')
            );
        });
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/venipak.php' => config_path('venipak.php'),
        ], 'config');
    }
}