<?php

namespace App\Models;

use App\Observers\CinemaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([CinemaObserver::class])]
class Cinema extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'visible_to_all' => 'boolean',
        ];
    }

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
