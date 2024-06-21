<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributorEmail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
