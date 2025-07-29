<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AccommodationTypeService extends Model
{
    protected $guarded = [];
    public function accommodationType()
    {
        return $this->belongsTo(AccommodationType::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
