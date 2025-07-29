<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Payments\Contracts\SupportsWebhooks;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentWebhookController extends Controller
{
    public function __invoke(string $driver, Request $request): Response
    {
        $gateway = app('payment')->gateway($driver);

        if (! $gateway instanceof SupportsWebhooks) {
            return response('Driver has no webhook support', 400);
        }

        $dto = $gateway->handleWebhook(
            signatureHeader: $request->header('Stripe-Signature') ?? $request->header('Paystack-Signature', ''),
            payload: $request->all()
        );

        // TODO : persister $dto, déclencher events, etc.

        return response('OK', 200);
    }
}
