<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\CreateBookingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Payments\Traits\ConvertsAmounts;
use Illuminate\Http\RedirectResponse;

final class CheckoutController extends Controller
{
    use ConvertsAmounts;

    public function __construct(
        public readonly CreateBookingAction $createBookingAction,
    )
    {
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $booking = $this->createBookingAction->execute($request);

            return redirect()->route('bookings.show', $booking->id)->with('success', 'Réservation effectuée avec succès ! Vous recevrez une confirmation par e-mail.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la réservation. Veuillez réessayer.')
                ->withInput();
        }

    }
}
