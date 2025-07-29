<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderPaymentRequest extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'payment_metadata' => 'array'
        ];
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'order_payment_request_id');
    }
}
