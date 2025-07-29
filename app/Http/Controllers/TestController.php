<?php

namespace App\Http\Controllers;

use App\Payments\DTO\PaymentRequestDTO;
use App\Payments\Enums\Currency;
use App\Payments\Facades\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class TestController extends Controller
{
    public function __construct(private readonly StripeClient $stripeClient)
    {
    }

    public function __invoke()
    {

        try {
            $reference = Str::uuid()->toString();
            $payment = Payment::gateway()->createPayment(new PaymentRequestDTO(
                reference: $reference,
                amountCents: 1,
                currency: Currency::EUR,
                description: 'Abonnement Premium',
                returnUrl: route('checkout.success'),
                cancelUrl: route('checkout.cancel'),
            ));
            return redirect($payment->redirectUrl);
        }catch (\Throwable $throwable){
            Log::channel('stack')->info($throwable->getMessage());
            throw ($throwable);
        }



    }
}
