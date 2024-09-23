<?php

namespace App\Models;

use App\Notifications\DistributorResetPassword;
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

    public function getDistributorNameAttribute()
    {
        return $this->distributor?->distributor_name ?: null;
    }

    public function sendPasswordResetNotification($token)
    {
        $mailLocale = 'en';
        switch ($this->distributor?->country->name) {
            case 'Germany':
                $mailLocale = 'de';
                break;
            case 'Austria':
                $mailLocale = 'de';
                break;
            case 'Switzerland':
                $mailLocale = 'de';
                break;
            case 'Luxembourg':
                $mailLocale = 'de';
                break;

            default:
                break;
        }

        $this->notify(new DistributorResetPassword($token, $mailLocale));
    }
}
