<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\Payment\OrderCreateEvent;
use App\Exceptions\StockDecrementException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

/**
 * Listener for OrderPaidEvent to decrement product stock quantities.
 *
 * This listener processes the OrderPaidEvent, validates the stock for each product in the order,
 * and decrements the quantities in the products table for limited stock products.
 * It uses a database transaction to ensure data integrity and throws StockDecrementException
 * if validation fails.
 *
 * @implements ShouldQueue
 */
class DecrementProductStockListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the OrderPaidEvent.
     *
     * @param OrderCreateEvent $event The event containing the order and payment reference.
     * @throws StockDecrementException If stock validation or decrement fails.
     */
    public function handle(OrderCreateEvent $event): void
    {
        DB::transaction(function () use ($event): void {
            // Load order items with products in a single query
            $orderItems = $event->order->items()->with('product')->get();

            // Validate each order item
            foreach ($orderItems as $item) {
                $product = $item->product;

                // Check if product exists
                if (!$product) {
                    throw StockDecrementException::productNotFound($item->product_id);
                }

                // Check if product is active
                if (!$product->is_active) {
                    throw StockDecrementException::productNotActive($product->name);
                }

                // Check stock for limited stock products
                if ($product->stockIsLimited() ) {
                    if ($item->quantity > $product->quantity) {
                        throw StockDecrementException::insufficientStock(
                            $product->name,
                            $item->quantity,
                            $product->quantity
                        );
                    }

                    // Decrement stock
                    $product->quantity -= $item->quantity;
                    $product->save();
                }
            }
        });
    }
}
