<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function versions(): HasMany
    {
        return $this->hasMany(MovieVersion::class);
    }

    public function distributors(): BelongsToMany
    {
        return $this->belongsToMany(Distributor::class, 'movie_distributors');
    }
}
