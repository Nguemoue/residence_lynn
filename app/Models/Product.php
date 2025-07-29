<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Enums\StockTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property array<string> $gallery
 */
final class Product extends Model
{
    use HasFactory;

    protected $casts = ['gallery' => 'array', 'is_active' => 'bool', 'stock_type' => StockTypeEnum::class];

    protected $guarded = [];

    /** @return BelongsTo<Category,Product> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<OrderItem> */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function isValidForCart(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->stock_type === StockTypeEnum::LIMITED && ($this->quantity === null || $this->quantity <= 0)) {
            return false;
        }

        return true;
    }

    public function stockIsLimited(): bool
    {
        return $this->stock_type === StockTypeEnum::LIMITED;
    }

    /** Prix réellement payé (prise en compte de la remise). */
    protected function effectivePrice(): Attribute
    {
        return Attribute::get(
            fn() => $this->discount_price ?? $this->price
        );
    }


    protected function coverImageUrl(): Attribute
    {
        return Attribute::get(function ($value, array $attributes) {
            if (is_null($attributes['cover_image']) || !Storage::disk('public')->exists($attributes['cover_image'])) {
                return 'https://placehold.net/default.png';
            }
            return asset('storage/' . $attributes['cover_image']);
        });
    }

    protected function galleryUrl(): Attribute
    {
        return Attribute::get(
            function ($value, array $attributes) {
                if ($attributes['gallery'] === null) {
                    return [];
                }
                return array_map(fn($item) => asset('storage/' . $item), $this->gallery);
            },
        );
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->withAttributes(['is_active' => true]);
    }

    protected function rating(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => 1,
            set: fn($value) => $value,
        );
    }

    protected function stockMessage(): Attribute
    {
        return Attribute::get(
            function ($value, array $attributes) {
                if ($this->stock_type === StockTypeEnum::UNLIMITED) {
                    return 'Stock illimité';
                }
                if ($this->quantity > 0) {
                    return 'Stock: ' . $this->quantity;
                }
                return 'Rupture de stock';
            },
        );
    }
}
