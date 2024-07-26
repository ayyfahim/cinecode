<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distributor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function emails(): HasMany
    {
        return $this->hasMany(DistributorEmail::class);
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
