<?php

namespace App\Models;

use App\Interfaces\UserInterface;
use App\Mail\CinemaPortalAccess;
use App\Mail\CinemaTheaterId;
use App\Observers\CinemaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

#[ObservedBy([CinemaObserver::class])]
class Cinema extends Authenticatable implements UserInterface
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['country_name'];

    protected function casts(): array
    {
        return [
            'visible_to_all' => 'boolean',
        ];
    }

    public function distributor(): BelongsTo
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

    public function getCountryNameAttribute($value)
    {
        if ($this->country?->name) {
            return $this->country?->name;
        }

        return null;
    }

    public function isAdmin()
    {
        return false;
    }

    public function sendPortalAccessMail()
    {
        $mailLocale = App::getLocale();
        switch ($this->country->name) {
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

        $data = [];
        $cinema_login_link = "https://" . config('filament.cinema_portal_url') . "?c={$this?->unique_hash}";
        $data['cinema_login_link'] = $cinema_login_link;

        foreach ($this->emails as $value) {
            Mail::to($value->email)->locale($mailLocale)->send(new CinemaPortalAccess($data));
            sleep(1);
        }
    }

    public function sendTheaterIdMail()
    {
        $mailLocale = App::getLocale();
        switch ($this->country->name) {
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

        $data = [];
        $data['cinema_hash'] = $this->unique_hash;

        foreach ($this->emails as $value) {
            Mail::to($value->email)->locale($mailLocale)->send(new CinemaTheaterId($data));
            sleep(1);
        }
    }
}
