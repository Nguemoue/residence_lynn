<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** @return BelongsTo<Order,OrderItem> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** @return BelongsTo<Product,OrderItem> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    protected function subtotal(): Attribute
    {
        return Attribute::get(fn() => $this->unit_price * $this->quantity);
    }
}
