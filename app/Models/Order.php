<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'validity_period_from' => 'datetime',
            'validity_period_to' => 'datetime',
        ];
    }

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(DistributorEmail::class, 'distributor_id', 'id');
    }

    public function cinemas(): BelongsToMany
    {
        return $this->belongsToMany(Cinema::class, 'order_cinemas', 'order_id', 'cinema_id');
    }

    public function order_cinemas(): HasMany
    {
        return $this->hasMany(OrderCinema::class);
    }

    // public function cinemas(): HasManyThrough
    // {
    //     return $this->hasManyThrough(Cinema::class, OrderCinema::class, 'order_id', 'id', 'id', 'cinema_id');
    // }
    // public function cinemas(): HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         Cinema::class, // Final model
    //         CinemaGroupCinema::class, // Intermediate model
    //         'cinema_group_id', // Foreign key on the intermediate model
    //         'id', // Foreign key on the final model
    //         'id', // Local key on the parent model
    //         'cinema_id' // Local key on the intermediate model
    //     );
    // }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(MovieVersion::class);
    }
}
