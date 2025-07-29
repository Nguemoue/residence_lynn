<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\Payment\OrderCreateEvent;
use App\Mail\OrderPaidMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

/**
 * Listener for OrderPaidEvent to send an email to the order's email address.
 *
 * This listener processes the OrderPaidEvent and sends a confirmation email
 * to the order's email address using a mailable class. The email is queueable
 * to improve performance.
 *
 * @implements ShouldQueue
 */
class SendOrderPaidNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the OrderPaidEvent.
     *
     * @param OrderCreateEvent $event The event containing the order and payment reference.
     */
    public function handle(OrderCreateEvent $event): void
    {
        Mail::to($event->order->email)->send(new OrderPaidMail($event->order));
    }
}
