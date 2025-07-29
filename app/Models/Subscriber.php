<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Subscriber extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];
}
