<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\CreateBookingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\AccommodationType;
use App\Payments\Traits\ConvertsAmounts;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class CheckoutController extends Controller
{
    use ConvertsAmounts;

    public function __construct(
        public readonly CreateBookingAction $createBookingAction,
    )
    {}
    public function show(AccommodationType $accommodationType): View
    {
        return view('pages.checkout.show',[
            'type' => $accommodationType,
            'disabledDates' => []
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $booking = $this->createBookingAction->execute($request);
            return redirect()->route('bookings.show', $booking->id)->with('success', 'Réservation effectuée avec succès ! Vous recevrez une confirmation par e-mail.');
        } catch (\Exception $e) {
            flash($e->getMessage(), 'error');
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la réservation. Veuillez réessayer.')
                ->withInput();
        }

    }
}
