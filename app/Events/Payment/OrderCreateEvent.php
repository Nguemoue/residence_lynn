<?php

namespace App\Events\Payment;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;

class OrderCreateEvent
{
    use Dispatchable;

    public function __construct(public string $reference,public Order $order)
    {
        //dd($this->reference);
    }
}
