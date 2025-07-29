<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    protected $guarded = [];

    //image url
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
