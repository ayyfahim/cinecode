<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CinemaGroupCinema extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function cinema_group(): BelongsTo
    {
        return $this->belongsTo(CinemaGroup::class);
    }
}
