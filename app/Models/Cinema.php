<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function distributors(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(CinemaEmail::class);
    }

    public function getEmailAttribute()
    {
        return $this->emails()?->get()?->first()?->email ?: null;
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
