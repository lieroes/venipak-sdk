<?php

namespace VenipakSDK\Facades;

use Illuminate\Support\Facades\Facade;

class Venipak extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \VenipakSDK\VenipakClient::class;
    }
}