<?php

namespace App\Helpers;

use App\Models\Cinema;

class CinemaUniqueAuth
{
    public function user()
    {
        $cinema = Cinema::select('name', 'unique_hash', 'city_name', 'id')->firstWhere('unique_hash', session()->get('unique_hash', '123'));

        if (!$cinema) {
            throw new \ErrorException('Cinema not found.');
        }

        return $cinema;
    }
}
