<?php

namespace App\Models;

use App\Observers\DistributorEmailObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([DistributorEmailObserver::class])]
class DistributorEmail extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
