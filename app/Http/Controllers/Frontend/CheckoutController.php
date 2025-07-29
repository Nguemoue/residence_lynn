<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\CheckoutAction;
use App\Domain\Services\CartService;
use App\Domain\Services\CheckoutService;
use App\Exceptions\InvalidCartException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\OrderPaymentRequest;
use App\Payments\DTO\PaymentRequestDTO;
use App\Payments\Enums\Currency;
use App\Payments\Facades\Payment;
use App\Payments\Traits\ConvertsAmounts;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CheckoutController extends Controller
{
    use ConvertsAmounts;

    public function __construct(
        private readonly CheckoutService $checkout,
        public readonly CheckoutAction   $checkoutAction,
        public readonly CartService      $cartService,
    )
    {
    }

    public function show(): View
    {
        return view('pages.checkout.show', [
            'cart' => $this->cartService->items(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $this->cartService->validateCart();
        } catch (InvalidCartException $e) {
            \Flasher\Prime\flash()->error(message: $e->getMessage());
            return back()->with('error', $e->getMessage());
        }

        $paymentReference = Str::uuid()->toString();
        //make the payment request
        $paymentDTO = DB::transaction(function () use ($request, $paymentReference) {
            $dataObject = Payment::gateway()->createPayment(
                new PaymentRequestDTO(
                    reference: $paymentReference,
                    amountCents: $this->toCents($this->cartService->total()),
                    currency: Currency::EUR,
                    description: "Payment de facture",
                    metadata: [],
                    returnUrl: route('checkout.success', ['ref' => $paymentReference]),
                    cancelUrl: route('checkout.cancel', ['ref' => $paymentReference])
                )
            );

            //create the payment order request
            OrderPaymentRequest::query()->create([
                'payment_reference' => $dataObject->reference,
                'payer_name' => $request->validated('surname'),
                'payer_address' => $request->validated('address'),
                'payer_email' => $request->validated('email'),
                'payer_postal_code' => $request->validated('postal_code'),
                'payer_city' => $request->validated('city'),
                'payer_surname' => $request->validated('surname'),
                'payer_phone' => $request->validated('phone'),
                'payment_method' => Payment::gateway()->getName(),
                'metadata' => ['cart' => $this->cartService->items()->toArray()],
                'payment_metadata' => $dataObject->raw
            ]);
            return $dataObject;
        });
        //put the gateway reference in session
        session()?->put('gateway_' . $paymentReference, $paymentDTO->reference);
        return redirect()->to($paymentDTO->redirectUrl);
    }
}
