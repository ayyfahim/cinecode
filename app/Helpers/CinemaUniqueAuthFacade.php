<?php

namespace App\Helpers;

use App\Models\Cinema;
use Illuminate\Support\Facades\Facade;

class CinemaUniqueAuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cinemaUniqueAuth';
    }
}
