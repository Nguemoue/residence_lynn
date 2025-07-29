<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function accommodation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }
}
