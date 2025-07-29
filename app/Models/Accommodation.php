<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'amenities' => 'array',
            'is_available' => 'boolean'
        ];
    }
    public function getCoverImageUrlAttribute(): string
    {
        //if the cover image doesn't exist render the fallback image
        if ($this->cover_image === null or \Storage::disk('public')->exists($this->cover_image)) {
            return asset('assets/images/fallback.png');
        }
        return asset('storage/' . $this->cover_image);
    }
    public function accommodationType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccommodationType::class);
    }
    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class,AccommodationService::class);
    }
}
