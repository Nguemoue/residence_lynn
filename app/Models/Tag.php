<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    /** Articles liés */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /** Produit lies */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
