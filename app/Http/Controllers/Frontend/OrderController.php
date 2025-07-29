<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;

final class OrderController extends Controller
{
    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('pages.orders.track', compact('order'));
    }
}
