<?php

declare(strict_types=1);

namespace App\Models;

use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', '=', true);
    }

    protected function readTime(): Attribute
    {
        return Attribute::get(
             function ($value, array $attributes) {
                $content = $attributes['content'] ?? '';
                $wordCount = str_word_count(strip_tags($content));
                 // moyenne de lecture : 200 mots/min
                return ceil($wordCount / 200);
            },
        );
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'author_id')->withDefault([
            'id' => 1,
            'name'=>"Admin",
            'avatar'=>'https://placehold.net/default.png',
            'email'=>'admin@gmail.com'
        ]);
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::get(function($value, array $attributes){
            if (is_null($attributes['cover_image']) || !Storage::disk('public')->exists($attributes['cover_image'])){
                return 'https://placehold.net/default.png';
            }
            return asset('storage/'.$attributes['cover_image']);
        });
    }
}
