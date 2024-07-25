<?php

namespace App\Models;

use App\Observers\MovieVersionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MovieVersionObserver::class])]
class MovieVersion extends Model
{
    use HasFactory;

    protected $guarded = [];
}
