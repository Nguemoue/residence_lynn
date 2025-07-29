<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new mailable instance.
     *
     * @param Order $order The order associated with the payment.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope The email envelope with subject and recipient.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('notifications.order_paid.subject', ['code' => '#'.$this->order->code]),
            to: $this->order->email,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content The email content with Markdown template.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-paid',
            with: [
                'order' => $this->order,
                'formatPrice' => fn (float $value): string => number_format($value, 2, ',', ' ') . ' €',
            ],
        );
    }
}
