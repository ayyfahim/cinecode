<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CinemaGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function cinemas(): HasMany
    // {
    //     return $this->hasMany(CinemaGroupCinema::class);
    // }

    public function cinemas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Cinema::class, // Final model
            CinemaGroupCinema::class, // Intermediate model
            'cinema_group_id', // Foreign key on the intermediate model
            'id', // Foreign key on the final model
            'id', // Local key on the parent model
            'cinema_id' // Local key on the intermediate model
        );
    }
}
