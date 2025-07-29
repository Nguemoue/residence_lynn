<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Payments\Exceptions\PaymentException;
use App\Payments\Facades\Payment;
use Illuminate\Http\Request;

class CheckoutActionSuccessController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(Request $request)
    {
        $queryReference = $request->query('ref');
        $sessionKey = 'gateway_' . $queryReference;
        if (!session()?->has($sessionKey)) {
            flash()->warning(message: "Aucune requete de paiement");
            return to_route('checkout.show');
        }
        $reference = $request->session()->get($sessionKey);
        $gateway = Payment::gateway();
        if (!$gateway->hasSuccessPayment(reference: $reference)) {
            flash()->warning(message: "Une erreur est survenu lors de la verification du paiement");
            return to_route('checkout.show');
        }
        try {
            $gateway->handleSuccessCheckout(reference: $reference);
            \Flasher\Prime\flash()->success("Le paiement de votre commande a ete finalise avec success");
        } catch (PaymentException $exception) {
            return redirect()->route('checkout.cancel', ['ref' => $reference])->with('error', 'Paiement non confirmé.');
        }
        return view('pages.checkout.success');
    }
}
