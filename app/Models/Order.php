<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property OrderStatusEnum $status
 */
final class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'uuid' => 'string',
        'status' => OrderStatusEnum::class,
        'status_note' => 'array',
        'payment_metadata' => 'array'
    ];

    protected $guarded = [];

    /** Génère automatiquement un UUID public. */
    protected static function boot(): void
    {
        parent::boot();
        self::creating(function (Order $order): void {
            $order->uuid = (string)Str::uuid();
        });
    }

    /** @return HasMany<OrderItem> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderPaymentRequest(): BelongsTo
    {
        return $this->belongsTo(OrderPaymentRequest::class);
    }

    protected function shippingTotal(): Attribute
    {
        return Attribute::get(fn() => 0); // ou une logique réelle
    }
}
