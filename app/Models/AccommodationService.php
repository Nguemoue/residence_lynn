<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationService extends Model
{
    public function accommodation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
