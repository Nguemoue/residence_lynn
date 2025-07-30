<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AccommodationType extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'gallery'=>'array',
            'price_per_night' => 'float',
            'is_available' => 'boolean',
            'amenities' => 'array'
        ];
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, AccommodationTypeService::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'accommodation_type_id');
    }

    //coverImage url
    public function getCoverImageUrlAttribute(): string
    {
        //if the cover image doesn't exist render the fallback image
        if ($this->cover_image === null or \Storage::disk('public')->exists($this->cover_image)) {
            return asset('assets/images/fallback.png');
        }
        return asset('storage/' . $this->cover_image);
    }

    //custon attribute for amenities
    public function getAmenitiesAttribute(): Collection
    {
        return collect([]);
    }
    public function getGalleryAttribute(): Collection
    {
        return collect([]);
    }
}
