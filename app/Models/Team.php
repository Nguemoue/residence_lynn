<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    protected $guarded = [];

    public function photoUrl(): Attribute
    {
        return Attribute::get(function ($value,$attributes){
           return (!is_null($attributes['photo']) && Storage::disk('public')->exists($attributes['photo']))?asset('storage/'.$attributes['photo']):'https://placehold.net/default.png';
        }) ;
    }
}
